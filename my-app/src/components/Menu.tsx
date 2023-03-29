import { border, Wrap, WrapItem } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import styled from "styled-components";

type Menus = {
    menu_id: number;
    name: string;
};
type MenuData = {
    id: number;
    name: string;
};

const Menu = () => {
    const [menus, setMenus] = useState<[Menus] | undefined>(undefined);

    // get↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    useEffect(() => {
        (async () => {
            try {
                const res = await axios.get("http://localhost:8888/api/menu");

                setMenus(res.data.menus);
                //サイトで拾ってきたコードにはconsoleのコードはなかったので自分で追記
                console.log(res);

                return;
            } catch (e) {
                return e;
            }
        })();
    }, []);
    // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
    // post↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
    const navigate = useNavigate();
    // 食材選択画面へ
    const handlePost = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_cook", { menu })
            .then((response) => {
                console.log("post", response.data);
                navigate("/MenuCook/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const handlePost1 = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_edit", { menu })
            .then((response) => {
                console.log("post1", response.data);
                navigate("/EditMenu/", { state: response.data });
            })
            .catch((error) => {
                console.error(error);
            });
    };

    const handlePost2 = (menu: any) => {
        axios
            .post("http://localhost:8888/api/menu_delete", { menu })
            .then((response) => {
                console.log("response", response.data);
                window.location.reload();
            });
    };
    // ↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

    return (
        <div className="Food">
            <div>
                <a href="/newMenu/">新規メニュー追加</a>
            </div>

            <Wrap>
                {menus &&
                    menus.map((menu) => (
                        <WrapItem key={menu.menu_id}>
                            <>
                                {" "}
                                <SCord>
                                    <p>{menu.name}</p>{" "}
                                    <div
                                        style={{ border: "1px solid black" }}
                                        onClick={() => handlePost(menu)}
                                    >
                                        選択する
                                    </div>
                                    <div
                                        style={{ border: "1px solid black" }}
                                        onClick={() => handlePost1(menu)}
                                    >
                                        編集
                                    </div>
                                    <div
                                        style={{ border: "1px solid black" }}
                                        onClick={() => handlePost2(menu)}
                                    >
                                        削除
                                    </div>
                                </SCord>
                            </>
                        </WrapItem>
                    ))}
            </Wrap>
        </div>
    );
};

const SCord = styled.div`
    border: solid 1px #ccc;
    border-radius: 8px;
    padding: 10px;
`;

export default Menu;
