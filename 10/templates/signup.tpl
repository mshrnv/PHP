<main class="form-signin">
    <form>
    <h1 class="h3 mb-3 fw-normal text-center">Please sign in</h1>

    <div class="form-floating">
        <input type="text" class="form-control" name="username" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
    </form>
    <!-- RootVar.$is_error=1 -->
    <div class="alert alert-danger text-center" role="alert" style="margin-top: 25px;">
        Registration error!
    </div>
    <!-- RootVar.$is_error_ends -->
</main>