import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import App from './App';
import reportWebVitals from './reportWebVitals';
import { BrowserRouter } from 'react-router-dom';
import Navbar from "./navbar";  // تأكد من أنك تستورد BrowserRouter هنا

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
    <React.StrictMode>
        <BrowserRouter> {}
            <Navbar />
                <App />
        </BrowserRouter>
    </React.StrictMode>
);

reportWebVitals();

