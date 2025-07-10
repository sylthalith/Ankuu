async function loadData() {
    const response = await fetch('/next');
    return await response.json();
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
//
// async function submit(rating) {
//     const formData = new FormData();
//     formData.append('session_card_id', data.session_card_id);
//     formData.append('rating', rating);
//     formData.append('_token', token);
//
//     const response = await fetch('/answer', {
//         method: 'POST',
//         body: formData
//     })
//
//     const a = await response.json()
//
//     if (a.success) {
//         back.classList.add('hidden')
//         again.classList.add('hidden')
//         hard.classList.add('hidden')
//         good.classList.add('hidden')
//         easy.classList.add('hidden')
//
//         data = await nextPromise
//         nextPromise = null
//
//         if (!data) {
//             data = await loadData()
//         }
//
//         await main()
//     }
// }
//
// async function main() {
//     if (!data) {
//         data = await loadData()
//     }
//
//     if (data.end) {
//         window.location.href = data.url;
//     }
//
//     showFront()
//     nextPromise = loadData()
// }

async function submit(rating) {
    console.time('submit-total');
    console.time('fetch-answer');
    const formData = new FormData();
    formData.append('session_card_id', data.session_card_id);
    formData.append('rating', rating);
    formData.append('_token', token);

    const response = await fetch('/answer', {
        method: 'POST',
        body: formData
    });
    console.timeEnd('fetch-answer');

    console.time('parse-answer');
    const a = await response.json();
    console.timeEnd('parse-answer');

    if (a.success) {
        console.time('hide-ui');
        back.classList.add('hidden');
        again.classList.add('hidden');
        hard.classList.add('hidden');
        good.classList.add('hidden');
        easy.classList.add('hidden');
        console.timeEnd('hide-ui');

        console.time('await-nextPromise');
        console.log('nextPromise before await:', nextPromise);
        data = await nextPromise;
        console.log('Data from nextPromise:', data);
        console.timeEnd('await-nextPromise');
        nextPromise = null;

        if (!data) {
            console.time('loadData-fallback');
            data = await loadData();
            console.timeEnd('loadData-fallback');
        }

        console.time('main');
        await main();
        console.timeEnd('main');
    }
    console.timeEnd('submit-total');
}

async function main() {
    console.time('main-total');
    if (!data) {
        console.time('loadData-main');
        data = await loadData();
        console.timeEnd('loadData-main');
    }

    if (data.end) {
        window.location.href = data.url;
    }

    console.time('showFront');
    showFront();
    console.timeEnd('showFront');

    console.time('start-nextPromise');
    nextPromise = loadData();
    console.timeEnd('start-nextPromise');
    console.timeEnd('main-total');
}

const loading = document.getElementById('loading')
const front = document.getElementById('front')
const back = document.getElementById('back')
const show = document.getElementById('show')
const again = document.getElementById('again')
const hard = document.getElementById('hard')
const good = document.getElementById('good')
const easy = document.getElementById('easy')

show.addEventListener('click', () => showBack())
again.addEventListener('click', () => submit('again'))
hard.addEventListener('click', () => submit('hard'))
good.addEventListener('click', () => submit('good'))
easy.addEventListener('click', () => submit('easy'))

let data = null
let nextPromise = null
const token = document.querySelector('meta[name="csrf-token"]').content

main()
