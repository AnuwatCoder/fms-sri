<?php

namespace App\Services;

use App\Models\Personnel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PersonnelService
{
    public function __construct(private readonly PublicFileStorage $files) {}

    /** @param array<string, mixed> $attributes */
    public function save(Personnel $person, array $attributes): Personnel
    {
        /** @var UploadedFile|null $photo */
        $photo = Arr::pull($attributes, 'photo');
        $removePhoto = (bool) Arr::pull($attributes, 'remove_photo', false);

        if ($photo) {
            $photoPath = $this->files->store($photo, 'portal/personnel');
            $this->files->delete($person->photo_path);
            $attributes['photo_path'] = $photoPath;
        } elseif ($removePhoto) {
            $this->files->delete($person->photo_path);
            $attributes['photo_path'] = null;
        }

        return DB::transaction(function () use ($attributes, $person): Personnel {
            if ($attributes['is_head']) {
                Personnel::query()
                    ->when($person->exists, fn ($query) => $query->whereKeyNot($person->getKey()))
                    ->update(['is_head' => false]);
            }

            $person->fill($attributes)->save();

            return $person;
        });
    }

    public function delete(Personnel $person): void
    {
        $this->files->delete($person->photo_path);
        $person->delete();
    }
}
