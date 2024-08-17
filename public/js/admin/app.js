import ControllAdminPanel from './adminPanell/ControllAdminPanel.js';

import RedrawConfigureHall from './adminPanell/configureHall/RedrawConfigureHall.js';
import ApiConfigureHall from './adminPanell/configureHall/ApiConfigureHall.js';

import RedrawConfigurePrice from './adminPanell/configurePrice/RedrawConfigurePrice.js';
import ApiConfigurePrice from './adminPanell/configurePrice/ApiConfigurePrice.js';


const panel = document.querySelector('.main-admin');
if(panel) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    
    const configureHall = document.querySelector('.conf-step__configure-hall');
    const configurePrice = document.querySelector('.conf-step__configure-price');

    const redraw = {
        hall : new RedrawConfigureHall(configureHall),
        price : new RedrawConfigurePrice(configurePrice),
    }

    const api = {
        hall : new ApiConfigureHall(token),
        price : new ApiConfigurePrice(token),
    }

    const controllAdminPanel = new ControllAdminPanel(redraw, api);
    controllAdminPanel.init();
}