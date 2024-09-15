import ControllBooking from "./booking/ControllBooking.js";
import RedrawBooking from "./booking/RedrawBooking.js";
import ApiBooking from "./booking/ApiBooking.js";
import StorageBooking from "./booking/StorageBooking.js";

import RedrawDateLine from "./date-line/RedrawDateLine.js";
import ControllDateLine from "./date-line/ControllDateLine.js";

const token = document.querySelector('meta[name="csrf-token"]')?.content;




// Выбор мест (страница)
const choosingPlase = document.querySelector('.buying');
if(choosingPlase) {
    const storage = new StorageBooking();
    const redraw = new RedrawBooking(choosingPlase, storage);
    const api = new ApiBooking(token)
    const controll = new ControllBooking(redraw, api);
    controll.init();
}

const dateLine = document.querySelector('.page-nav');
if(dateLine) {
    const redraw = new RedrawDateLine(dateLine);
    const controll = new ControllDateLine(redraw);
    controll.init();
}