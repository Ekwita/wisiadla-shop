<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AddressController extends Controller
{

    public function checkAddressExists(Request $request): RedirectResponse
    {
        $user = $request->user();
        $actualAddress = Address::where('user_id', $user->id)->first();
        $validatedData = $this->validateRequest($request);

        if ($actualAddress !== null) {
            $this->updateAddress($actualAddress, $validatedData);
            return Redirect::route('profile.edit')->with('status', 'address-updated');
        } else {
            $this->storeAddress($user, $validatedData);
            return Redirect::route('profile.edit')->with('status', 'profile-updated');
        }
    }
    private function storeAddress(User $user, array $validatedData): void
    {
        $validatedData['user_id'] = $user->id;
        $address = new Address($validatedData);

        $address->save();
    }

    private function updateAddress(Address $actualAddress, array $validatedData): void
    {
        $actualAddress->update($validatedData);
    }

    private function validateRequest(Request $request): array
    {
        $validatedData = $request->validate([
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'string|max:255',
            'postal_code' => 'required|string|max:10',
            'country' => 'required|string|max:255',
        ]);

        return $validatedData;
    }
}
