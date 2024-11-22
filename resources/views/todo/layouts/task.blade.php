@php
    $statusColors = [
        App\Models\Todo::STATUS_TODO => 'danger',
        App\Models\Todo::STATUS_IN_PROGRESS => 'warning',
        App\Models\Todo::STATUS_DONE => 'success'
    ];
    $statusNames = [
        App\Models\Todo::STATUS_TODO => 'Do zrobienia',
        App\Models\Todo::STATUS_IN_PROGRESS => 'W trakcie',
        App\Models\Todo::STATUS_DONE => 'Zakończone'
    ];
    $color = $statusColors[$item->task_status] ?? 'danger';
    $statusName = $statusNames[$item->task_status] ?? 'Do zrobienia';
    
    $user = $item->user;
    $assignedUser = $item->assignedUser;
@endphp
<!-- Card body -->
<div class="row">
    <div class="card m-2 border-{{ $color }} w-100 text-light task-card">
        <div class="card-header">
            <!-- todo title -->
            <h5 class="card-title">
                {{ Str::title(Str::limit($item->title, 27)) }}
            </h5>
            <!-- todo subtitle -->
            @if ($group)
                <h6 class="card-subtitle mb-2 text-muted">
                    @if ($assignedUser)
                        <i class="fas fa-user-check"></i> Przypisano do: {{ $assignedUser->name }}
                    @else
                        <i class="fas fa-user"></i> Utworzył: {{ $user->name }}
                    @endif
                </h6>
            @endif
        </div>
        <!-- card body -->
        <div class="card-body">
            <!-- todo description -->
            <p class="card-text">
                {{ Str::title(Str::limit($item->description, 50)) }}
            </p>
        </div>
        <!-- card footer / buttons -->
        <div class="card-footer">
            <div class="btn-group">
                <!-- Action dropdown button -->
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <!-- Edit button -->
                        <li>
                            <a class="dropdown-item" data-toggle="modal" data-target="#editModal"
                                data-id="{{ $item->id }}" 
                                data-title="{{ Str::title($item->title) }}"
                                data-description="{{ Str::title($item->description) }}"
                                data-status="{{ $item->task_status }}"
                                data-assigned="{{ $assignedUser?->email }}">Edytuj</a>
                        </li>
                        <!-- Delete button -->
                        <li>
                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteModal"
                                data-id="{{ $item->id }}"
                                data-title="{{ Str::title($item->title) }}">Usuń</a>
                        </li>
                        <!-- Group actions -->
                        @if ($group)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Assign buttons -->
                            <li>
                                <a class="dropdown-item" data-toggle="modal" data-target="#assignModal"
                                    data-id="{{ $item->id }}" 
                                    data-assigned="{{ $assignedUser?->email }}">
                                    Przypisz
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- Info button -->
                <button class="btn btn-primary ml-1 rounded" data-toggle="modal" data-target="#infoModal"
                    data-id="{{ $item->id }}" 
                    data-title="{{ Str::title($item->title) }}"
                    data-description="{{ Str::title($item->description) }}" 
                    data-status="{{ $item->task_status }}"
                    data-status-name="{{ $statusName }}"
                    data-created="{{ $item->created_at->format('Y-m-d H:i:s') }}"
                    data-updated="{{ $item->updated_at->format('Y-m-d H:i:s') }}"
                    @if ($group) 
                        data-who="{{ $user->name }}" 
                        data-assign="{{ $assignedUser?->name ?? 'Nikt' }}"
                    @endif>
                    <i class="fas fa-info"></i>
                </button>
            </div>
            <!-- Change status buttons -->
            <div style="float: right;">
                @switch($item->task_status)
                    @case(App\Models\Todo::STATUS_TODO)
                        <!-- Status up -->
                        <a href="{{ route('todo.post.up', $item->id) }}?group_id={{ $group->id ?? '' }}" 
                           class="btn btn-primary">
                            <i class="fas fa-angle-double-right"></i>
                        </a>
                    @break

                    @case(App\Models\Todo::STATUS_IN_PROGRESS)
                        <div class="btn-group">
                            <!-- Status down -->
                            <a href="{{ route('todo.post.down', $item->id) }}?group_id={{ $group->id ?? '' }}" 
                               class="btn btn-primary mr-1">
                                <i class="fas fa-angle-double-left"></i>
                            </a>
                            <!-- Status up -->
                            <a href="{{ route('todo.post.up', $item->id) }}?group_id={{ $group->id ?? '' }}" 
                               class="btn btn-primary">
                                <i class="fas fa-angle-double-right"></i>
                            </a>
                        </div>
                    @break

                    @case(App\Models\Todo::STATUS_DONE)
                        <!-- Status down -->
                        <a href="{{ route('todo.post.down', $item->id) }}?group_id={{ $group->id ?? '' }}" 
                           class="btn btn-primary">
                            <i class="fas fa-angle-double-left"></i>
                        </a>
                    @break
                @endswitch
            </div>
        </div>
    </div>
</div>
