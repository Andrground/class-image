<form action="{{ route('adm.image.store') }}" method="POST" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="form-group">
        <label for="img">Escolha um arquivo</label>
        <input type="file" name="img" id="img">
    </div>
    <button type="submit" class="btn btn-default">Salvar</button>
</form>