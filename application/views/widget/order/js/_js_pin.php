<script>

document.addEventListener('DOMContentLoaded', () => {
        const pincodeInput = new PincodeInput('#pincode', {
            autoFocus: true,
            allowPaste: true,
            secure: true,
            forceDigits: true,
            length: 6,
            styles: {
                '.pincode-grid': {
                    'margin': '5px',
                    'padding': '5px',
                    'width': '50px',
                    'text-align': 'center',
                    'text-align': 'center',
                    'line-height': 'normal',
                    'display': 'flex',
                    'align-items': 'center',
                    'justify-content': 'center',
                    'border-radius': '8px'
                },
            },
            onInput: (value, idx) => {
                console.log(value);
            },
            onComplete: (value) => {
                document.getElementById("enterpinform").submit();
            }
        });
    });
</script>