import * as React from 'react';
import ReactDOM from "react-dom/client";
import "./styles/index.scss";
import App from "./App";
import {BrowserRouter, HashRouter} from "react-router-dom";

let selector = document.getElementById("wp-sync-scss");
if (selector) {
    const el = ReactDOM.createRoot(document.getElementById("wp-sync-scss"));
    el.render(
       <App/>
    );
}