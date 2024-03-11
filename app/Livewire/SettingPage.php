<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Mary\Traits\Toast;

class SettingPage extends Component
{
    use Toast;

    public function clearCache()
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            try {
                Artisan::call('cache:clear');
                $this->success('Cache cleared successfully.');
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function clearView()
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            try {
                Artisan::call('view:clear');
                $this->success('View cleared successfully.');
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function clearRoute()
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            try {
                Artisan::call('route:clear');
                $this->success('Route cleared successfully.');
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function clearConfig()
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            try {
                Artisan::call('config:clear');
                $this->success('Config cleared successfully.');
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function clearEvent()
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            try {
                Artisan::call('event:clear');
                $this->success('Event cleared successfully.');
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function clearOptimize()
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            try {
                Artisan::call('optimize:clear');
                $this->success('Optimize cleared successfully.');
            } catch (\Throwable $th) {
                $this->error($th->getMessage());
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function render()
    {
        return view('livewire.setting-page');
    }
}
