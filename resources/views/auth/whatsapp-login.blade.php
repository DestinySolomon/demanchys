<form action="/send-otp" method="POST">
    @csrf
    <label>Enter WhatsApp Number</label>
    <input type="text" name="phone" required>

    <button type="submit">Send OTP via WhatsApp</button>
</form>
