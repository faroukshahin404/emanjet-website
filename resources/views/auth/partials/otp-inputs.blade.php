<div class="otp-inputs text-center mb-4">
    <div class="otp-grid d-flex justify-content-center gap-3">
        @for ($i = 0; $i < 4; $i++)
        <input type="text"
               maxlength="1"
               class="otp-box text-center"
               id="otp{{ $i }}"
               name="otp[{{ $i }}]"
               inputmode="numeric"
               pattern="[0-9]*"
               style="width: 62px; padding: 10px;" />
    @endfor

    </div>

    @if($errors->has('otp'))
        <div class="text-danger mt-2">
            <small>{{ $errors->first('otp') }}</small>
        </div>
    @endif
</div>

<div class="countdown text-center mt-3" id="timer">
    <!-- سيتم تحديث العد التنازلي هنا -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const otpInputs = document.querySelectorAll('.otp-input');
        const timerDisplay = document.getElementById('timer');
        let countdown = calculateRemainingTime();
        let timer;

        // دالة لحساب الوقت المتبقي
        function calculateRemainingTime() {
            const expiresAt = new Date('{{ session("otp_expires_at") }}');
            const now = new Date();
            const diff = Math.floor((expiresAt - now) / 1000);
            return Math.max(0, diff);
        }

        // تحديث العد التنازلي
        function updateTimer() {
            if (countdown > 0) {
                const minutes = Math.floor(countdown / 60);
                const seconds = countdown % 60;
                timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                countdown--;
                timer = setTimeout(updateTimer, 1000);
            } else {
                timerDisplay.textContent = '00:00';
            }
        }

        // بدء العد التنازلي
        updateTimer();
    });
    document.addEventListener('DOMContentLoaded', function () {
        const inputs = document.querySelectorAll('.otp-box');

        inputs.forEach((input, index) => {
            input.addEventListener('input', () => {
                if (input.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value === '' && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });
    });
</script>
