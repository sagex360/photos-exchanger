@props(['id' => $name, 'name'])
<textarea id="{{ $id }}" name="{{ $name }}"
          class="form-control @error($name) is-invalid @enderror"
          rows="3" placeholder="Post content"
          required="required">{{ $slot }}</textarea>
