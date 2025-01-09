<!DOCTYPE html>
<html>
<head>
    <title>Library Management System</title>
    <link rel="stylesheet" href="{{ asset('css/Admin.login.css') }}">
</head>
<body>
    <div>
        <img src="{{ asset('assets/UNIARCHIVE LOGO.png') }}" width="450" />

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <p>
                Username:
                <input type="text" name="username" size="35" maxlength="50" value="{{ old('username') }}" />
                @error('username')
                    <div style="color: yellow;">{{ $message }}</div>
                @enderror
            </p>
            <p>
                Password:
                <input type="password" name="password" size="35" maxlength="16" />
                @error('password')
                    <div style="color: yellow;">{{ $message }}</div>
                @enderror
            </p>
            <p>
                <input type="submit" value="Log-In" />
            </p>
        </form>
    </div>
</body>
</html>
