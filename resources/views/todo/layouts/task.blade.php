@php
    switch ($item->task_status) {
        case 1:
            $color = 'danger';
            break;
        case 2:
            $color = 'warning';
            break;
        case 3:
            $color = 'success';
            break;
        default:
            $color = 'danger';
            break;
    }
@endphp
<!-- Card body -->
<div class="row">
    <div class="card m-2 border-{{ $color }} w-100 text-light task-card">
        <div class="card-header">
            <!-- todo title -->
            @if (strlen($item->title) >= 30)
                <h5 class="card-title">{{ Str::title(substr($item->title, 0, 27) . '...') }}</h5>
            @else
                <h5 class="card-title">{{ Str::title($item->title) }}</h5>
            @endif
            <!-- todo subtitle -->
            @if ($group != null)
                @if ($item->assigned() == null)
                    <h6 class="card-subtitle mb-2 text-muted">Utworzył: {{ $item->user()->name }}</h6>
                @else
                    <h6 class="card-subtitle mb-2 text-muted">Przypisano do: {{ $item->assigned()->name }}</h6>
                @endif
            @endif
        </div>
        <!-- card body -->
        <div class="card-body">
            <!-- todo description -->
            @if (strlen($item->description) >= 50)
                <p class="card-text">{{ Str::title(substr($item->description, 0, 50) . '...') }}</p>
            @else
                <p class="card-text">{{ Str::title($item->description) }}</p>
            @endif
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
                                data-id="{{ $item->id }}" data-title="{{ Str::title($item->title) }}"
                                data-description="{{ Str::title($item->description) }}"
                                data-status="{{ $item->task_status }}">Edytuj</a>
                        </li>
                        <!-- Delete button -->
                        <li>
                            <a class="dropdown-item" data-toggle="modal" data-target="#deleteModal"
                                data-id="{{ $item->id }}">Usuń</a>
                        </li>
                        <!-- Group actions -->
                        @if ($group != null)
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Assign buttons -->
                            <li>
                                <a class="dropdown-item" data-toggle="modal" data-target="#assignModal"
                                    data-id="{{ $item->id }}" data-asigned="{{ $item->assigned()->email ?? '' }}">
                                    Przypisz
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- Info button -->
                <button class="btn btn-primary ml-1 rounded" data-toggle="modal" data-target="#infoModal"
                    data-id="{{ $item->id }}" data-title="{{ Str::title($item->title) }}"
                    data-description="{{ Str::title($item->description) }}" data-status="{{ $item->task_status }}"
                    @if ($group != null) data-who="{{ $item->user()->name }}" data-assign="{{ $item->assigned()->name ?? 'Nikt' }}" @endif>
                    <i class="fas fa-info"></i>
                </button>
            </div>
            <!-- Change status buttons -->
            <div style="float: right;">
                @switch($item->task_status)
                    @case(1)
                        <!-- Status up -->
                        <form action="{{ route('todo.post.up', $item->id) }}">
                            <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}" />
                            <button class="btn btn-primary"><i class="fas fa-angle-double-right"></i></button>
                        </form>
                    @break

                    @case(2)
                        <div class="btn-group">
                            <!-- Status down -->
                            <form action="{{ route('todo.post.down', $item->id) }}">
                                <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}" />
                                <button class="btn btn-primary mr-1"><i class="fas fa-angle-double-left"></i></button>
                            </form>
                            <!-- Status up -->
                            <form action="{{ route('todo.post.up', $item->id) }}">
                                <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}" />
                                <button class="btn btn-primary"><i class="fas fa-angle-double-right"></i></button>
                            </form>
                        </div>
                    @break

                    @case(3)
                        <!-- Status down -->
                        <form action="{{ route('todo.post.down', $item->id) }}">
                            <input type="hidden" name="group_id" value="{{ $group->id ?? '' }}" />
                            <button class="btn btn-primary"><i class="fas fa-angle-double-left"></i></button>
                        </form>
                    @break

                    @default
                    @break
                @endswitch
            </div>
        </div>
    </div>
</div>
