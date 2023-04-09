import React from "react";
import { Link } from "react-router-dom";

function GlobalNav() {
    return (
        <ul>
            <li>
                <Link to="/">
                    <span>Top</span>
                </Link>
            </li>
            <li>
                <Link to="/about">
                    <span className="nav-title">About</span>
                </Link>
            </li>
        </ul>
    );
}

export default GlobalNav;
