import ControllAdminPanel from './adminPanell/ControllAdminPanel.js';
import RedrawConfigureHall from './adminPanell/configureHall/RedrawConfigureHall.js';
import ApiConfigureHall from './adminPanell/configureHall/ApiConfigureHall.js';

const panel = document.querySelector('.main-admin');
if(panel) {
    const token = document.querySelector('meta[name="csrf-token"]').content;
    
    const configureHall = document.querySelector('.conf-step__configure-hall')

    const redraw = {
        hall : new RedrawConfigureHall(configureHall),
    }

    const api = {
        hall : new ApiConfigureHall(token),
    }

    const controllAdminPanel = new ControllAdminPanel(redraw, api);
    controllAdminPanel.init();
}