<div class="modal fade zoom" tabindex="-1" id="addEditCategoryModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@if(!$viewingMode){{$updatingMode?'Update Category':'New Category'}}@else Category Details @endif</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-inner">
                            
                            <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateCategory':'AddCategory'}}">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="name" wire:model.lazy="state.name" {{$viewingMode? 'disabled':''}}>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Category Configuration</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="preview-block">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" wire:model="state.status" {{$viewingMode? 'disabled':''}}>
                                                                <label class="custom-control-label" for="customSwitch2">Status</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="phone-no-1">Description</label>
                                            <div class="form-control-wrap">
                                                <textarea class="form-control @error('description') is-invalid @enderror no-resize" id="default-textarea" placeholder="Brief Category Description" wire:model="state.description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                </div>
                            
                        </div>
                    </div>
                </div>
                @if(!$viewingMode)
                <div class="modal-footer bg-light">
                    <div class="form-group">
                        
                        <button type="submit" class="btn btn-lg btn-primary">Save Information</button>
                        
                    </div>
                </div>
                @endif
                </form>
            </div>
        </div>
    </div>