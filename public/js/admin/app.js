import ControllAdminPanel from './adminPanell/ControllAdminPanel.js';

import RedrawConfigureHall from './adminPanell/configureHall/RedrawConfigureHall.js';
import ApiConfigureHall from './adminPanell/configureHall/ApiConfigureHall.js';

import RedrawConfigurePrice from './adminPanell/configurePrice/RedrawConfigurePrice.js';
import ApiConfigurePrice from './adminPanell/configurePrice/ApiConfigurePrice.js';

import RedrawSessionGrid from './adminPanell/sessionGrid/RedrawSessionGrid.js';
import ApiSessionGrid from './adminPanell/sessionGrid/ApiSessionGrid.js';

import RedrawActivationSales from './adminPanell/activationSales/RedrawActivationSales.js';
import ApiActivationSales from './adminPanell/activationSales/ApiActivationSales.js';


const panel = document.querySelector('.main-admin');
if(panel) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    
    const configureHall = document.querySelector('.conf-step__configure-hall');
    const configurePrice = document.querySelector('.conf-step__configure-price');
    const sessionGrid = document.querySelector('.conf-step__session-grid');
    const activationSales = document.querySelector('.conf-step__activate-sales');

    const redraw = {
        hall : new RedrawConfigureHall(configureHall),
        price : new RedrawConfigurePrice(configurePrice),
        session : new RedrawSessionGrid(sessionGrid),
        activation : new RedrawActivationSales(activationSales), 
    }

    const api = {
        hall : new ApiConfigureHall(token),
        price : new ApiConfigurePrice(token),
        session : new ApiSessionGrid(token),
        activation : new ApiActivationSales(token), 
    }

    const controllAdminPanel = new ControllAdminPanel(redraw, api);
    controllAdminPanel.init();
}