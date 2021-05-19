<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Rules\ChangingPassword;
use App\Rules\passwordValidation;
use App\Http\Requests\SettingsStoreRequest;
class SettingsController extends Controller
{
    public function change()
    {
        // return view("settings/change");
    }
    public function index()
    {
        return view("settings.settings");
    }
    public function store(SettingsStoreRequest $request)
    {
        $currentUser = auth()->user();
        $oldPassword = $request->input("fPassword");
        $newPassword = $request->input("nPassword");
        $p = strcmp($oldPassword, $newPassword);
        $validate = $request->validated();
        if ($validate) {
            $currentUser->update([
                "password" => bcrypt($request->input("nPassword")),
            ]);

            return redirect()
                ->route("settingsPanel")
                ->with('message', 'Password has been changed :)');
        } else {
            return redirect('/settings/create');
        }
    }
    public function deleteForm(Request $request)
    {
        return view("settings.deleteForm");
    }

    public function deleteAccountStore(Request $request)
    {
        $currentUser = auth()->user();
        $validate = $request->validate([
            "ReceiveValue" => [
                "required",
                "string",
                new passwordValidation(
                    $request->input("ReceiveValue"),
                    $currentUser->password
                ),
            ],
        ]);
        if ($validate) {
            return redirect("/");
        }
    }
}
