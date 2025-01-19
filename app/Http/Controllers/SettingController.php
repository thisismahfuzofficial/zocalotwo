<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  */
    public function index()
    {


        return view('pages.settings.update',);
    }



    public function updateSettings(Request $request)
    {
        Cache::flush();
        // Validate the form data
        $request->validate([
            'site_title' => 'required|string|max:255',
            'site_email' => 'required|email|max:255',
            'site_phone' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        // dd($request->all());
        // Update the site title
        Setting::where('key', 'site.title')->update(['value' => $request->input('site_title')]);
        // Update the site title
        Setting::where('key', 'site.subtitle')->update(['value' => $request->input('site_subtitle')]);
        // Update the site email
        Setting::where('key', 'site.email')->update(['value' => $request->input('site_email')]);
        // Update the site phone
        Setting::where('key', 'site.phone')->update(['value' => $request->input('site_phone')]);
        // Update the facebook link
        Setting::where('key', 'facebook.link')->update(['value' => $request->input('facebook_link')]);
        // Update the site instream link
        Setting::where('key', 'instagram.link')->update(['value' => $request->input('instagram_link')]);
        // Update the site tiktok link
        Setting::where('key', 'tiktok.link')->update(['value' => $request->input('tiktok_link')]);
        // Update the site google api
        Setting::where('key', 'google.map')->update(['value' => $request->input('google_map')]);
        // Update the site order mail
        Setting::where('key', 'order.mail')->update(['value' => $request->input('order_mail')]);
        // Update the site Extra Charge
        Setting::where('key', 'extra.charge')->update(['value' => $request->input('extra_charge')]);
        // Update the site Extra Charge
        Setting::where('key', 'pdf.file')->update(['value' => $request->input('pdf_file')]);



        if ($request->hasFile('image')) {
            $currentImage = Setting::where('key', 'site.logo')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('image')->store('images', 'public');
            Setting::where('key', 'site.logo')->update(['value' => $path]);
        }

        //laft
        if ($request->hasFile('laft')) {
            $currentImage = Setting::where('key', 'slide.laft')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('laft')->store('images', 'public');
            Setting::where('key', 'slide.laft')->update(['value' => $path]);
        }
        if ($request->hasFile('laft-top')) {
            $currentImage = Setting::where('key', 'slide.laft_top')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('laft-top')->store('images', 'public');
            Setting::where('key', 'slide.laft_top')->update(['value' => $path]);
        }
        if ($request->hasFile('laft-bottom')) {
            $currentImage = Setting::where('key', 'slide.laft_bottom')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('laft-bottom')->store('images', 'public');
            Setting::where('key', 'slide.laft_bottom')->update(['value' => $path]);
        }


        //right
        if ($request->hasFile('right')) {
            $currentImage = Setting::where('key', 'slide.right')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('right')->store('images', 'public');
            Setting::where('key', 'slide.right')->update(['value' => $path]);
        }
        if ($request->hasFile('right-top')) {
            $currentImage = Setting::where('key', 'slide.right_top')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('right-top')->store('images', 'public');
            Setting::where('key', 'slide.right_top')->update(['value' => $path]);
        }
        if ($request->hasFile('right-bottom')) {
            $currentImage = Setting::where('key', 'slide.right_bottom')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('right-bottom')->store('images', 'public');
            Setting::where('key', 'slide.right_bottom')->update(['value' => $path]);
        }
        if ($request->hasFile('hero_image')) {
            $currentImage = Setting::where('key', 'site.hero_image')->value('value');
            if (Storage::exists($currentImage)) {
                Storage::delete($currentImage);
            }
            $path = $request->file('hero_image')->store('images', 'public');
            Setting::where('key', 'site.hero_image')->update(['value' => $path]);
        }
        // Optionally, add a success message and redirect
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirmed',
        ]);

        $user = auth()->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect');
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully');
    }
    public function storeHeroImage(Request $request)
    {
        foreach ($request->hero_image as $image) {
            SliderImage::create([
                'slider_image' => $image->store('images'),
            ]);
        }
        return redirect(route('settings.index'))->with('success', 'Hero image was successfully stored');
    }
    public function deleteImage(SliderImage $hero)
    {

        $hero->delete();
        return redirect()->back()->with('success', 'Slider Image deleted');
    }
}
