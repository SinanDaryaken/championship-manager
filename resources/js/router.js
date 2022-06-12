// Define Components

import Home from "./Pages/Home";
import Fixture from "./Pages/Fixture";
import Game from "./Pages/Game";


const General = {
    template: '<router-view></router-view>',
}

export const routes = [
    {path: '/', name: "home", component: Home},
    {path: '/fixture', name: "fixture", component: Fixture},
    {path: '/game', name: "game", component: Game},
];


