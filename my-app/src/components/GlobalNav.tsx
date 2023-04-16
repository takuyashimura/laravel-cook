import React, { ReactNode } from "react";
import { Link, useNavigate } from "react-router-dom";
import axios from "axios";
import swal from "sweetalert";

function GlobalNav() {
    const navigation = useNavigate();

    const logoutSubmit = (e: any) => {
        e.preventDefault();

        axios.post(`/api/logout`).then((res) => {
            if (res.data.status === 200) {
                localStorage.removeItem("auth_token");
                localStorage.removeItem("auth_namee");
                swal("ログアウトしました", res.data.message, "success");
                navigation("/");
                window.location.reload();
            }
        });
    };

    let AuthButtons: ReactNode;

    if (!localStorage.getItem("auth_token")) {
        AuthButtons = (
            <ul>
                <li>
                    <Link to="/register">
                        <span>Register</span>
                    </Link>
                </li>
                <li>
                    <Link to="/login">
                        <span>Login</span>
                    </Link>
                </li>
            </ul>
        );
    } else {
        AuthButtons = (
            <li>
                <div onClick={logoutSubmit}>
                    <span className="text-white">ログアウト</span>
                </div>
            </li>
        );
    }

    return (
        <ul>
            <li>
                <Link to="/">
                    <span>Top</span>
                </Link>
            </li>
            <li>
                <Link to="/about">
                    <span>About</span>
                </Link>
            </li>
            {AuthButtons}
        </ul>
    );
}

export default GlobalNav;
