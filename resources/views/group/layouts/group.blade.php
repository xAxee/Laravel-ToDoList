<div class="card m-2 border-danger w-100 text-light task-card">
    <div class="card-body">
        <h5 class="card-title">{{ Str::title($group->name) }}</h5>
        <p class="card-text">{{ Str::title($group->description) }}</p>

        <a href="{{ route('group.list', $group->id) }}" class="btn btn-primary"><i class="fas fa-list-ul"></i> Zobacz
            zadania</a>
        @if ($group->owner_id == Auth::id())
            <a href="{{ route('group.settings', $group->id) }}" class="btn btn-secondary"><i class="fas fa-cog"></i></a>
            <button class="btn btn-info" data-toggle="modal" data-target="#inviteModal"
                data-link="{{ $group->invite_link }}"><i class="fas fa-share-square"></i></button>
        @endif
    </div>
</div>
