const openPopupButton = document.getElementById('open-from');
const closePopupButton = document.getElementById('close-popup');
const popup = document.getElementById('popup');

openPopupButton.addEventListener('click', () => {
    popup.style.display = 'block';
});

closePopupButton.addEventListener('click', () => {
    popup.style.display = 'none';
    const url = window.location.href;
    location.href = url.split('?')[0] + '?page=editorialCalendar';
});

const urlString = window.location.search;
const queryString = new URLSearchParams(urlString);
if (queryString.get('page') === 'editorialCalendar' && queryString.get('action') === 'edit') {
    popup.style.display = 'block';
}
