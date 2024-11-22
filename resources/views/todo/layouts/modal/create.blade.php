<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="createModelLabel">
                    <i class="fas fa-plus-circle"></i> Dodaj zadanie
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('todo.post.store') }}" method="POST" class="needs-validation" novalidate>
                    {{ csrf_field() }}
                    <input type="hidden" name="group_id" value="{{ $group->id }}" />
                    <div class="form-group row">
                        <label for="title" class="col-4 col-form-label">
                            <i class="fas fa-heading"></i> Tytuł
                        </label>
                        <div class="col-8">
                            <input id="title" name="title" placeholder="Tytuł zadania" type="text" 
                                class="form-control @error('title') is-invalid @enderror"
                                required="required" value="{{ old('title') }}">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="description">
                            <i class="fas fa-align-left"></i> Opis
                        </label>
                        <div class="col-8">
                            <textarea id="description" name="description" style="resize: none;" cols="40" rows="5" 
                                class="form-control @error('description') is-invalid @enderror"
                                aria-describedby="descriptionHelpBlock" required="required" 
                                placeholder="Szczegółowy opis zadania">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small id="descriptionHelpBlock" class="form-text text-muted">
                                Opisz szczegółowo zadanie do wykonania
                            </small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="assign" class="col-4 col-form-label">
                            <i class="fas fa-user-tag"></i> Przypisz
                        </label>
                        <div class="col-8">
                            <select id="assign" name="assign" class="custom-select">
                                <option value="">Nikt</option>
                                @foreach($group->getAllUsers() as $user)
                                    <option value="{{ $user->email }}" {{ old('assign') == $user->email ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-4 col-form-label">
                            <i class="fas fa-tasks"></i> Status
                        </label>
                        <div class="col-8">
                            <select id="status" name="status" class="custom-select @error('status') is-invalid @enderror" required="required">
                                @foreach(App\Models\Todo::getAvailableStatuses() as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', request('status')) == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times"></i> Zamknij
                        </button>
                        <button name="submit" type="submit" class="btn btn-success">
                            <i class="fas fa-plus"></i> Dodaj
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
