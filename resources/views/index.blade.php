<!DOCTYPE html>
<html lang="mx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Catálogo</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('lib/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/sweetalert/sweetalert.css') }}">
    <link rel="stylesheet" href="../resources/css/app.css">
</head>

<body>
    <nav class="navbar bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Catálogo</span>
        </div>
    </nav>
    <div class="container">
        <div class="row pt-4">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <form id="productoForm">
                            @csrf
                            <input type="hidden" id="producto_id">
                            <div class="mb-3">
                                <label class="form-label">Producto:</label>
                                <input type="text" class="form-control" name="producto" id="producto"
                                    placeholder="Nombre del producto" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descripción:</label>
                                <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Descripción corta del producto" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Precio:</label>
                                <input type="number" name="precio" step="0.01" min="0" class="form-control" id="precio"
                                    placeholder="$0.00" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cantidad:</label>
                                <input type="number" name="cantidad" step="0.01" min="0" class="form-control" id="cantidad"
                                    placeholder="0" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-body">
                        <table class="w-100 table table-hover table-bordered border-dark" id="tablaProductos">
                            <thead class="table table-dark">
                                <tr>
                                    <th scope="col">Producto</th>
                                    <th scope="col">Descripción</th>
                                    <th scope="col">Precio</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('lib/bootstrap/bootstrap.js') }}"></script>
<script src="{{ asset('lib/jquery/jquery.js') }}"></script>
<script src="{{ asset('lib/datatables/datatables.js') }}"></script>
<script src="{{ asset('index.js') }}"></script>
<script src="{{ asset('lib/sweetalert/sweetalert.js') }}"></script>

</html>
