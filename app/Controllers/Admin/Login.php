<?php

namespace App\Controllers\Admin;

class Login extends BaseController
{
    public function index()
    {
        if ($this->authLib->isLoggedIn()) {
            return redirect()->to('/' . ADMIN_PATH . '/dashboard');
        }

        $msg = (int)$this->request->getVar("msg", FILTER_VALIDATE_INT);
        $msg_text = [
            '1' => 'نام کاربری یا گذرواژه نادرست است.',
            '2' => 'هنگام ورود خطایی رخ داده است.',
            '3' => 'حساب کاربری شما غیرفعال است.',
            '4' => 'کد امنیتی نادرست یا منقضی شده است.',
        ];

        $this->viewData['msg_text'] = isset($msg_text[$msg]) ? $msg_text[$msg] : null;

        return view($this->viewPath . 'login/index', $this->viewData);
    }

    public function authenticate()
    {
        helper('sanitize');

        $rules = [
            'username' => [
                'label' => 'نام کاربری',
                'rules' => 'required|min_length[3]|max_length[50]'
            ],
            'password' => [
                'label' => 'رمز عبور',
                'rules' => 'required|min_length[3]'
            ],
            'captcha' => [
                'label' => 'کد امنیتی',
                'rules' => 'required|exact_length[4]|numeric'
            ]
        ];

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            $errors = $validation->getErrors();
            $this->flash('validation_error');
            return redirect()->to('/' . ADMIN_PATH . '/login?msg=1');
        }

        $captcha = (string) $this->request->getPost('captcha');
        $captchaHash = (string) session()->get('admin_captcha_hash');
        $captchaExpires = (int) session()->get('admin_captcha_expires');
        session()->remove(['admin_captcha_hash', 'admin_captcha_expires']);

        if ($captchaHash === '' || $captchaExpires < time() || !password_verify($captcha, $captchaHash)) {
            return redirect()->to('/' . ADMIN_PATH . '/login?msg=4')->withInput();
        }

        $userModel = model('App\Models\Admin\UserModel');

        $username = $this->request->getPost('username', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);
        $password = $this->request->getPost('password', FILTER_CALLBACK, ['options' => 'sanitizeStripTags']);

        $user = $userModel->where('username', $username)
            ->where('password', $password)
            ->where('is_active', 1)
            ->first();

        if ($user === null) {
            $this->flash('user_not_found');
            return redirect()->to('/' . ADMIN_PATH . '/login?msg=1');
        }

        $user_id = (int)$user['id'];

        if ($user_id < 1) {
            $this->flash('user_not_found');
            return redirect()->to('/' . ADMIN_PATH . '/login?msg=1');
        }

        $userModel->updateLastLogin($user_id);

        $login_result = $this->authLib->login($user_id, [
            'full_name' => $user['full_name'],
            'role' => $user['role'],
            'avatar' => $user['avatar']
        ]);

        if ($login_result) {
            $this->flash('login_success');
            return redirect()->to('/' . ADMIN_PATH . '/dashboard');
        }

        $this->flash('login_success');
        return redirect()->to('/' . ADMIN_PATH . '/login?msg=2');
    }

    public function logout()
    {
        service('adminAuth')->logout();
        session()->setFlashdata('success', 'با موفقیت وارد شدید');
        return redirect()->to('/' . ADMIN_PATH . '/login');
    }

    public function captcha()
    {
        $code = (string) random_int(1000, 9999);
        session()->set([
            'admin_captcha_hash' => password_hash($code, PASSWORD_DEFAULT),
            'admin_captcha_expires' => time() + 180,
        ]);

        $width = 170;
        $height = 58;
        $pixels = array_fill(0, $width * $height * 3, 246);
        $setPixel = static function (int $x, int $y, array $color) use (&$pixels, $width, $height): void {
            if ($x < 0 || $x >= $width || $y < 0 || $y >= $height) return;
            $offset = ($y * $width + $x) * 3;
            $pixels[$offset] = $color[0];
            $pixels[$offset + 1] = $color[1];
            $pixels[$offset + 2] = $color[2];
        };

        for ($i = 0; $i < 1200; $i++) {
            $shade = random_int(95, 220);
            $setPixel(random_int(0, $width - 1), random_int(0, $height - 1), [$shade, $shade, $shade]);
        }

        for ($line = 0; $line < 13; $line++) {
            $x0 = random_int(0, $width - 1); $y0 = random_int(0, $height - 1);
            $x1 = random_int(0, $width - 1); $y1 = random_int(0, $height - 1);
            $steps = max(abs($x1 - $x0), abs($y1 - $y0), 1);
            $color = [random_int(80, 180), random_int(80, 180), random_int(80, 180)];
            for ($step = 0; $step <= $steps; $step++) {
                $x = (int) round($x0 + ($x1 - $x0) * $step / $steps);
                $y = (int) round($y0 + ($y1 - $y0) * $step / $steps);
                $setPixel($x, $y, $color);
                $setPixel($x + 1, $y, $color);
            }
        }

        $font = [
            '0'=>['01110','10001','10011','10101','11001','10001','01110'],
            '1'=>['00100','01100','00100','00100','00100','00100','01110'],
            '2'=>['01110','10001','00001','00010','00100','01000','11111'],
            '3'=>['11110','00001','00001','01110','00001','00001','11110'],
            '4'=>['00010','00110','01010','10010','11111','00010','00010'],
            '5'=>['11111','10000','10000','11110','00001','00001','11110'],
            '6'=>['01110','10000','10000','11110','10001','10001','01110'],
            '7'=>['11111','00001','00010','00100','01000','01000','01000'],
            '8'=>['01110','10001','10001','01110','10001','10001','01110'],
            '9'=>['01110','10001','10001','01111','00001','00001','01110'],
        ];

        foreach (str_split($code) as $index => $digit) {
            $scale = random_int(5, 6);
            $startX = 13 + $index * 39 + random_int(-3, 3);
            $startY = random_int(7, 13);
            $color = [random_int(15, 65), random_int(15, 65), random_int(55, 110)];
            foreach ($font[$digit] as $row => $bits) {
                foreach (str_split($bits) as $column => $bit) {
                    if ($bit !== '1') continue;
                    for ($dy = 0; $dy < $scale; $dy++) {
                        for ($dx = 0; $dx < $scale; $dx++) {
                            $wave = (int) round(sin(($row * $scale + $dy) / 5 + $index) * 2);
                            $setPixel($startX + $column * $scale + $dx + $wave, $startY + $row * $scale + $dy, $color);
                        }
                    }
                }
            }
        }

        $raw = '';
        for ($y = 0; $y < $height; $y++) {
            $raw .= "\x00";
            $offset = $y * $width * 3;
            for ($x = 0; $x < $width * 3; $x++) $raw .= chr($pixels[$offset + $x]);
        }
        $chunk = static function (string $type, string $data): string {
            return pack('N', strlen($data)) . $type . $data . pack('N', crc32($type . $data));
        };
        $png = "\x89PNG\r\n\x1a\n"
            . $chunk('IHDR', pack('NNCCCCC', $width, $height, 8, 2, 0, 0, 0))
            . $chunk('IDAT', gzcompress($raw, 9))
            . $chunk('IEND', '');

        return $this->response
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setContentType('image/png')
            ->setBody($png);
    }
}
