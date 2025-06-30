<h1>Halaman Pengguna</h1>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="dropdown-item">
        Log out
    </button>
</form>

<div class="dropdown-menu dropdown-menu-end">
                                <a href="{{ route('profile.edit.user') }}" class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
                                <a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Log out
                                    </button>
                                </form>
                            </div>
