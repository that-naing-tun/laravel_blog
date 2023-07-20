<!-- navbar -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="/" class="navbar-brand">Creative Coder</a>
        <div class="d-flex">
            <a href="/#blogs" class="nav-link">Blogs</a>
            @auth
                <img src="{{ auth()->user()->avatar }}" width="50" height="50" class="rounded-circle" alt="">
                <a href="" class="nav-link">Wellcome {{ auth()->user()->name }}</a>
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" href="" class="nav-link btn btn-link">Logout</button>
                </form>
            @else
                <a href="/register" class="nav-link">Register</a>
                <a href="/login" class="nav-link">Login</a>
            @endauth
            <a href="#subscribe" class="nav-link">Subscribe</a>
        </div>
    </div>
</nav>
