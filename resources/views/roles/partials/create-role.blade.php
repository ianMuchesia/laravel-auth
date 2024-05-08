<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create Role') }}
        </h2>
    </header>
   
    <form method="post" action="{{ route('roles.store') }}" class="mt-6 space-y-6">
        @csrf
        @method('post')


        <div class="row mb-3">
            <label for="" class="col-sm-3 col-form-label">Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" autocomplete="off">
                @error('name')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
        </div>


        <h5 class="pb-3">Permissions</h5>
        @error('permission')
        <span class="text-danger">{{$message}}</span>
        @enderror


        @foreach($permissions as $item)
        <div class="form-check mb-2">
            <input type="checkbox" value="{{$item->id}}" class="form-check-input" name="permission[]">
            <label class="form-check-label" for="checkChecked">
                {{$item->name}}
            </label>
        </div>
        @endforeach


        <div class="mt-3">
            <button type="submit" class="px-4 py-2 bg-red-600 text-white">SAVE</button>
        </div>


    </form>
</section>