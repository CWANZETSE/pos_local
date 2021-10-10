<div class="modal fade zoom" tabindex="-1" id="addEditProductModal" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$updatingMode?'Update Product':'New Product'}}</h5>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card-inner">
                            
                            <form autocomplete="off" wire:submit.prevent="{{$updatingMode ? 'updateProduct':'AddProduct'}}">
                                <div class="row g-4">
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label class="form-label" for="full-name-1">Category</label>
                                        <div class="form-control-select">
                                            <select class="form-control @error('category_id') is-invalid @enderror" id="default-06" wire:model="state.category_id">
                                                <option value="">--Select Category--</option>
                                                @foreach($categories as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">Product Configuration</label>
                                            <ul class="custom-control-group g-3 align-center">
                                                <li>
                                                    <div class="col-md-3 col-sm-6">
                                                        <div class="preview-block">
                                                            <div class="custom-control custom-switch">
                                                                <input type="checkbox" class="custom-control-input" id="customSwitch2" wire:model="state.status">
                                                                <label class="custom-control-label" for="customSwitch2">Status</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="full-name-1">Name</label>
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" aria-describedby="name" wire:model.lazy="state.name" {{$viewingMode? 'disabled':''}}>
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