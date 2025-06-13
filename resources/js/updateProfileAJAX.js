document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('updateUserForm');

    // При загрузке страницы — подставляем актуальные данные
    initProfileDisplay();

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const res = await fetch(window.Laravel.routes.updateProfile, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': window.Laravel.csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (!res.ok) {
                throw new Error('Ошибка сети');
            }

            const data = await res.json();

            showFlash('success', data.message);
            updateProfileDisplay(data.updated);

        } catch (error) {
            console.error(error);
            showFlash('danger', 'Ошибка при обновлении профиля.');
        }
    });

    function showFlash(type, message) {
        const flashDiv = document.getElementById('updateUserResponse');
        if (!flashDiv) return;

        flashDiv.className = 'alert alert-' + type;
        flashDiv.innerHTML = message;
        flashDiv.style.display = 'block';
        flashDiv.style.opacity = '0';
        flashDiv.style.transition = 'opacity 0.5s ease';

        setTimeout(() => {
            flashDiv.style.opacity = '1';
        }, 10);

        setTimeout(() => {
            flashDiv.style.opacity = '0';
            setTimeout(() => {
                flashDiv.style.display = 'none';
            }, 500);
        }, 3000);
    }

    function updateProfileDisplay(data) {
        // Имя + Отчество + буква + цвет
        updateAvatarAndName(data.first_name, data.middle_name);

        // Обновляем поля формы
        document.getElementById('first_name').value = data.first_name;
        document.getElementById('middle_name').value = data.middle_name;
        document.getElementById('last_name').value = data.last_name;
        document.getElementById('email').value = data.email;
        document.getElementById('birth_date').value = data.birth_date || '';
        document.getElementById('phone').value = data.phone || '';
        document.getElementById('address').value = data.address || '';
    }

    function updateAvatarAndName(firstName, middleName) {
        const bgColor = wordToColor(firstName);
        const initial = firstName.length > 0 ? firstName[0] : '';

        const avatarCircle = document.getElementById('userAvatarCircle');
        if (avatarCircle) {
            avatarCircle.style.backgroundColor = bgColor;
        }

        const avatarInitial = document.getElementById('userAvatarInitial');
        if (avatarInitial) {
            avatarInitial.textContent = initial;
        }

        const userNameDisplay = document.getElementById('userNameDisplay');
        if (userNameDisplay) {
            userNameDisplay.textContent = `${firstName} ${middleName}`;
        }
    }

    function wordToColor(word) {
        let sum = 0;
        for (let i = 0; i < word.length; i++) {
            sum += word.charCodeAt(i);
        }
        const r = (sum * 13) % 256;
        const g = (sum * 27) % 256;
        const b = (sum * 55) % 256;
        return `rgb(${r}, ${g}, ${b})`;
    }

    // Инициализация при первой загрузке страницы
    function initProfileDisplay() {
        const firstName = document.getElementById('first_name').value;
        const middleName = document.getElementById('middle_name').value;
        const last_name = document.getElementById('last_name').value;
        const email = document.getElementById('email').value;
        const birth_date = document.getElementById('birth_date').value;
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;

        updateAvatarAndName(firstName, middleName);
    }
});
