function showError(message) {
    hideAll()
    error.classList.remove('hidden')
    error.textContent = message
}

function hideAll() {
    loading.classList.add('hidden')
    front.classList.add('hidden')
    back.classList.add('hidden')
    show.classList.add('hidden')
    again.classList.add('hidden')
    hard.classList.add('hidden')
    good.classList.add('hidden')
    easy.classList.add('hidden')
}

async function loadData() {
    const response = await fetch('/next');
    return await response.json();
}

async function sendData(rating) {
    const formData = new FormData();
    formData.append('session_card_id', data.session_card_id);
    formData.append('rating', rating);
    formData.append('_token', token);
    const response = await fetch('/answer', {
        method: 'POST',
        body: formData
    })

    return await response.json()
}

function showFront() {
    front.textContent = data.front

    loading.classList.add('hidden')
    front.classList.remove('hidden')
    show.classList.remove('hidden')
}

function showBack() {
    back.textContent = data.back

    again.textContent = `Again ${Math.round(data.intervals.again)}d`
    hard.textContent = `Hard ${Math.round(data.intervals.hard)}d`
    good.textContent = `Good ${Math.round(data.intervals.good)}d`
    easy.textContent = `Easy ${Math.round(data.intervals.easy)}d`

    show.classList.add('hidden')
    back.classList.remove('hidden')
    again.classList.remove('hidden')
    hard.classList.remove('hidden')
    good.classList.remove('hidden')
    easy.classList.remove('hidden')
}

async function submit(rating) {
    sendData(rating).catch(error => {
        showError(error.message || "Ошибка при отправке данных")
    })

    back.classList.add('hidden')
    again.classList.add('hidden')
    hard.classList.add('hidden')
    good.classList.add('hidden')
    easy.classList.add('hidden')

    data = await nextData
    nextData = null

    await main()
}

async function main() {
    if (!data) {
        data = await loadData()
    }

    if (data.end) {
        window.location.href = data.url;
    }

    nextData = loadData()

    showFront()
}

const loading = document.getElementById('loading')
const front = document.getElementById('front')
const back = document.getElementById('back')
const show = document.getElementById('show')
const again = document.getElementById('again')
const hard = document.getElementById('hard')
const good = document.getElementById('good')
const easy = document.getElementById('easy')
const error = document.getElementById('error')

show.addEventListener('click', () => showBack())
again.addEventListener('click', () => submit('again'))
hard.addEventListener('click', () => submit('hard'))
good.addEventListener('click', () => submit('good'))
easy.addEventListener('click', () => submit('easy'))

let data = null
let nextData = null
const token = document.querySelector('meta[name="csrf-token"]').content

main()
