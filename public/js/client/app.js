import ControllChoosingPlace from "./choosing-place/ControllChoosingPlace.js";
import RedrawChoosingPlace from "./choosing-place/RedrawChoosingPlace.js";
import StorageChoosingPlace from "./choosing-place/StorageChoosingPlace.js";
import ApiChoosingPlace from "./choosing-place/ApiChoosingPlace.js";

const token = document.querySelector('meta[name="csrf-token"]')?.content;

const welcome = document.querySelector('.movie');

if(welcome) {
    sessionStorage.clear();
}

// Выбор мест (страница)
const choosingPlase = document.querySelector('.buying');
if(choosingPlase) {
    const storage = new StorageChoosingPlace();
    const redraw = new RedrawChoosingPlace(choosingPlase, storage);
    const api = new ApiChoosingPlace(token)
    const controll = new ControllChoosingPlace(redraw, api);
    controll.init();
}
