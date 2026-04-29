<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    public function login()
    {
        $session = session();

        return view('login', [
            'username' => $session->get('username'),
            'errors'   => $session->getFlashdata('errors') ?? [],
            'success'  => $session->getFlashdata('success'),
        ]);
    }

    public function authenticate()
    {
        $rules = [
            'username' => 'required|min_length[3]|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = trim((string) $this->request->getPost('username'));

        $userModel = new UserModel();
        $userId = $userModel->insert(['username' => $username], true);

        $session = session();
        $session->set([
            'user_id'  => $userId,
            'username' => $username,
        ]);

        return redirect()->to('/')->with('success', 'Utilisateur enregistré.');
    }
}
