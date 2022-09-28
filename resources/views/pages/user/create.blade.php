<div class="container-fluid p-5 bg-primary text-white text-center">
    <h1>{{ $pageName }}</h1>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12">
            <a href="javascript:void(0)" class="btn btn-success float-end mb-5 w-20 goBack"
                data-create-href={{ $action }}>Go Back</a>
        </div>

        <div class="col-sm-12">
            <form id="submit-form" action="{{ $action }}" class="row g-3" method="POST" autocomplete="off">
                @csrf
                @if (isset($objData->id))
                    <input type="hidden" value="{{ $objData->id }}" name="id">
                @endif
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="@if (isset($objData->name) && $objData->name) {{ $objData->name }} @endif" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="@if (isset($objData->email) && $objData->email) {{ $objData->email }} @endif" required>
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="@if (isset($objData->phone) && $objData->phone) {{ $objData->phone }} @endif" required>
                </div>
                <div class="col-md-6">
                    <label for="photo" class="form-label">Photo</label>
                    <input class="form-control form-control" id="photo" name="photo" type="file"
                        @if (!isset($objData)) required @endif>
                    @if (isset($objData->photo))
                        <img src="{{ asset('storage/' . $objData->photo) }}" width="50" class="mt-3">
                    @endif
                </div>
                @if (!isset($objData))
                    <div class="col-md-6">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="col-md-6">
                        <label for="verify_password" class="form-label">Verify Password</label>
                        <input type="password" class="form-control" id="verify_password" name="verify_password"
                            required>
                    </div>
                @endif
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    /* JQuery Validations */
    $("#submit-form").validate({
        rules: {
            password: {
                minlength: 5
            },
            verify_password: {
                minlength: 5,
                equalTo: "#password"
            }
        }
    });
</script>
