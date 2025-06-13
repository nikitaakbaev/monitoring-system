document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('addUserForm');
    const responseDiv = document.getElementById('addUserResponse');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = {
            first_name: form.first_name.value,
            middle_name: form.middle_name.value,
            last_name: form.last_name.value,
            roleID: form.roleID.value,
            email: form.email.value,
            password: form.password.value,
        };

        try {
            const res = await fetch(window.Laravel.routes.createUser, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(formData),
            });

            if (!res.ok) throw new Error('Ошибка сети');

            const data = await res.json();

            responseDiv.innerHTML = `<p>${data.message}<p>`;
            responseDiv.classList.remove('d-none');
        } catch (error) {
            responseDiv.innerHTML = `<p>Ошибка при добавлении пользователя.</p>`;
            responseDiv.classList.remove('d-none');
            console.error(error);
        }
    });
});
