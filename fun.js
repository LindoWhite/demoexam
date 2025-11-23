let current = 0, total = 0, interval;
const galleryInfo = $('.info_gallery'), gallery = $('.gallery');

const resetChangeSlideInterval = () => {
    clearInterval(interval);

    const func = () => show((current + 1) % total);
    interval = setInterval(func, 3000);
};

const loadGallery = () => {
    const images = Array.from({ length: 4 }).map((_, index) =>`./assets/gallery/${index}.png`);
    total = images.length;

    const dots = $('<div>', { class: 'dots' });
    images.forEach((path, index) => {
        const img = $("<img>", { src: path, class: index === 0 ? 'active' : '' });
        gallery.append(img);

        const dot = $("<span>", { class: index === 0 ?  'dot active' : 'dot', 'data-slide': index });
        dots.append(dot);
    });
    gallery.append(dots);
};

function show(index) {
    const images = $('.gallery img');
    const dots = $('.dot');

    images.removeClass('active');
    dots.removeClass('active');

    images.eq(index).addClass('active');
    dots.eq(index).addClass('active');

    current = index;
    resetChangeSlideInterval();
}

loadGallery();
resetChangeSlideInterval();

gallery.on('click', '.dot', function() {
    show(parseInt($(this).data('slide')));
});

galleryInfo.on('click', '.control', function() {
    switch ($(this).data('action')) {
        case 'next': current + 1 >= total ? current = 0 : current++; break;
        case 'prev': current - 1 < 0 ? current = total - 1 : current--; break;
        default: break;
    }
    show(current);
});