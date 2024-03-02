<nav class="main-menu bg-light shadow">
    @if (Auth::user())
        <h5 id="username" style="display: none" class="text-dark w-100 text-center">{{ Auth::user()->name }}</h5>
    @endif
    <ul>
        <li class="mt-4 mb-3">
            <a href="{{ route('posts.index') }}" class="">
                <i class="fa fa-film fa-2x fs-4 mt-3"></i>
                <span class="nav-text">
                    Home
                </span>
            </a>
        </li>
        <li>
            <a href="{{ route('user.index') }}">
                <i class="fa fa-search fa-2x"></i>
                <span class="nav-text">
                    Search
                </span>
            </a>
        </li>
        <li class="has-subnav mb-3">
            <a href="{{ route('posts.create') }}" class="">
                <i class="fa fa-paper-plane fa-2x fs-4 mt-3"></i>
                <span class="nav-text">
                    What's on your mind
                </span>
            </a>

        </li>
        <li class="has-subnav mb-3">
            <a href="{{ route('saved-posts.show') }}" class="">
                <i class="fa fa-floppy-disk fa-2x fs-4 mt-3"></i>
                <span class="nav-text">
                    Saved Posts
                </span>
            </a>

        </li>
        <li class="has-subnav mb-3">
            <a href="{{ route('profile.index', ['user' => Auth::user()]) }}" class="">
                <i class="fa fa-user fa-2x fs-4 mt-3"></i>
                <span class="nav-text">
                    Profile
                </span>
            </a>

        </li>

        <ul class="logout">
            <li class="mb-2 text-white">
                <a id="logoutAnchor" style="cursor: pointer;" class="">
                    <i class="fa fa-power-off fa-2x fs-4 mt-3"></i>
                    <span class="nav-text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
</nav>

<form id="logoutForm" action="{{ route('logout') }}" method="post">
    @csrf
</form>

<script>
    document.querySelector(".main-menu").addEventListener('mouseover', function() {
        document.getElementById('username').style.display = 'block';
    });

    document.querySelector(".main-menu").addEventListener('mouseout', function() {
        document.getElementById('username').style.display = 'none';
    });
    document.getElementById("logoutAnchor").addEventListener('click', () => {
        document.getElementById("logoutForm").submit();
    })
</script>
