<form action="/verify-otp" method="POST">
    @csrf
    <input type="hidden" name="phone" value="{{ $phone }}">

    <label>Enter OTP</label>
    <input type="text" name="otp" required>

    <button type="submit">Verify OTP</button>
</form>
