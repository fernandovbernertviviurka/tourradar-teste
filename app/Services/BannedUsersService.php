<?php

namespace App\Services;

use App\Models\User;
use App\Services\BannedUserOptions;
use Illuminate\Contracts\Database\Eloquent\Builder;

class BannedUsersService
{

    const FILTER_INCLUDE_TRASHED = 'withTrashed';
    const FILTER_ONLY_TRASHED = 'trashedOnly';
    const FILTER_EXCLUDE_TRASHED = 'withoutTrashed';

    private Builder $query;

    public function __construct($options)
    {
        $this->query = User::query();
        $this->filters = $options;
    }

    public function getUsers(): Builder
    {
        $this->setQuery();
        $this->applyFilters();


        if ($this->getSortBy()) {
            $this->query->orderBy($this->getSortBy());
        }

        return $this->query;
    }

    public function applyFilters(): void
    {

        if ($this->isActiveUsersOnlyFilter()) {
            $this->query->whereNotNull('activated_at');
        }

        if ($this->isNoAdminFilter()) {
            $this->query->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'admin');
            });
        }

        if ($this->isAdminOnlyFilter()) {
            $this->query->whereHas('roles', function ($query) {
                $query->where('name', 'admin');
            });
        }

        $this->query->whereNotNull('banned_at');


    }

    private function isActiveUsersOnlyFilter(): bool
    {
        return (bool) ($this->filters['activeUsersOnly'] ?? false);
    }

    private function isNoAdminFilter(): bool
    {
        return (bool) ($this->filters['noAdmin'] ?? false);
    }

    private function isAdminOnlyFilter(): bool
    {
        return (bool) ($this->filters['adminOnly'] ?? false);
    }

    // Mapping the array of banned users to a new array
    public function outputResults($users)
    {
        if ($this->shouldSaveFile()) {
            $this->saveToFile($this->getSavePath());
        }

        $bannedUsers = $this->getBannedUsersData($users);

        $rows = array_map(fn($user) => $user, $bannedUsers);
        
        return $rows;
    }

    // format the output breaking row on a foreach
    protected function formatOutput($rows)
    {
        $output = '';

        foreach ($rows as $row) {
            $output .= implode("\t", $row) . PHP_EOL;
        }

        return $output;
    }

    
    private function setQuery(): void
    {
        $includeTrashed = $this->filters[self::FILTER_INCLUDE_TRASHED] ?? false;
        $onlyTrashed = $this->filters[self::FILTER_ONLY_TRASHED] ?? false;

        $action = match (true) {
            $includeTrashed => fn() => $this->query->withTrashed(),
            $onlyTrashed => fn() => $this->query->onlyTrashed(),
            default => fn() => $this->query->withoutTrashed(),
        };

        $action();
    }
        
    public function saveToFile(string $path): void
    {
        $users = $this->getUsers()->get();

        $data = '';

        if ($this->withHeaders()) {
            $data .= 'ID,Email,Banned_at' . PHP_EOL;
        }

        foreach ($users as $user) {
            $data .= "{$user->id};{$user->email};{$user->banned_at}" . PHP_EOL;
        }

        file_put_contents($path . $this->generateFileName(), $data);
    }

    protected function getBannedUsersData($users)
    {
        return $users->get(['id','email','banned_at'])->toArray();
    }

    protected function convertToOutputString($user)
    {
        return [$user->id, $user->email, $user->banned_at];
    }

    public function setHeader(){
        return  $this->withHeaders() ? ['id', 'email', 'banned_at'] : [];
    }

    public function getSortBy(): string
    {
        return $this->filters['sortBy'] ?? 'id';
    }

    protected function withHeaders(): bool
    {
        return $this->filters['withHeaders'];
    }

    protected function shouldSaveFile(): bool
    {
        return is_string($this->filters['saveTo']);
    }

    protected function getSavePath(): String
    {
        return $this->filters['saveTo'];
    }

    protected function generateFileName(){
        return time() . '.txt';
    }
}
