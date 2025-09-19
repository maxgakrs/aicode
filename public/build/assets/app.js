// Custom JavaScript for Costume Rental System
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    // Confirm delete actions
    const deleteForms = document.querySelectorAll('form[onsubmit*="confirm"]');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('คุณแน่ใจหรือไม่ที่จะดำเนินการนี้?')) {
                e.preventDefault();
            }
        });
    });

    // Date input validation
    const startDateInputs = document.querySelectorAll('#rental_start_date');
    const endDateInputs = document.querySelectorAll('#rental_end_date');
    
    startDateInputs.forEach((startInput, index) => {
        const endInput = endDateInputs[index];
        if (startInput && endInput) {
            startInput.addEventListener('change', function() {
                if (this.value) {
                    endInput.min = this.value;
                    if (endInput.value && endInput.value <= this.value) {
                        endInput.value = '';
                    }
                }
            });
        }
    });

    // Available date validation
    const fromDateInputs = document.querySelectorAll('#available_from');
    const toDateInputs = document.querySelectorAll('#available_to');
    
    fromDateInputs.forEach((fromInput, index) => {
        const toInput = toDateInputs[index];
        if (fromInput && toInput) {
            fromInput.addEventListener('change', function() {
                if (this.value) {
                    toInput.min = this.value;
                    if (toInput.value && toInput.value <= this.value) {
                        toInput.value = '';
                    }
                }
            });
        }
    });
});
