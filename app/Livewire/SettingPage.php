<?php

namespace App\Livewire;

use App\Jobs\CleanBackupJob;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Lazy;
use Livewire\Attributes\Title;
use Livewire\Component;
use Mary\Traits\Toast;

#[Lazy]
#[Title('application settings')]
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

    public function deleteBackup(string $fileName)
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
            $filePath = config('backup.backup.name') . '/' . $fileName;

            if ($disk->exists($filePath)) {
                $disk->delete($filePath);
                $this->success('Backup database file has been delete.');
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function downloadBackup(string $fileName)
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
            $filePath = config('backup.backup.name') . '/' . $fileName;

            if ($disk->exists($filePath)) {
                return response()->download($disk->path($filePath));
            } else {
                abort(404, 'File not found.');
            }
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function cleanBackup()
    {
        if (Auth::check() && Auth::user()->email === 'developermithu@gmail.com') {
            CleanBackupJob::dispatch();
            $this->info('Backup cleaning job dispatched.');
        } else {
            $this->error('You are not authorized to perform this action.');
        }
    }

    public function render()
    {
        if (!Auth::user()->isSuperadmin()) {
            abort(403);
        }

        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->allFiles(config('backup.backup.name'));

        $totalSize = 0;
        $backupFiles = [];

        foreach ($files as $file) {
            // Only consider files with .zip extension
            if (pathinfo($file, PATHINFO_EXTENSION) === 'zip' && $disk->exists($file)) {
                $fileName = pathinfo($file, PATHINFO_BASENAME);

                // Get file size in bytes
                $fileSize = $disk->size($file);
                $totalSize += $fileSize;

                $backupFiles[] = [
                    'file_path' => $file,
                    'file_name' => $fileName,
                    'file_size' => $this->bytesToHuman($fileSize),
                    'created_at' => Carbon::parse($disk->lastModified($file))->diffForHumans(),
                ];
            }
        }

        // Convert total size to human-readable format
        $totalSizeHumanReadable = $this->bytesToHuman($totalSize);

        // Reverse the array to display newest backups at the top
        $backupFiles = array_reverse($backupFiles);

        return view('livewire.setting-page', compact('backupFiles', 'totalSizeHumanReadable'));
    }

    private function bytesToHuman($bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }
}
