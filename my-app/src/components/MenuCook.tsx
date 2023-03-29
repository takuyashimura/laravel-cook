import { Button } from "@chakra-ui/react";
import axios from "axios";
import { useEffect, useState } from "react";
import { useLocation } from "react-router-dom";

const MenuCook = () => {
    const [food, setFood] = useState<any>();
    // const navigator = useNavigate();
    const location = useLocation();

    useEffect(() => {
        setFood(location.state);
        console.log("location", location.state);
    }, []);
    console.log("food", food);

    const handlePost = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        axios
            .post("http://localhost:8888/api/add_buy_list", food)
            .then((response) => {
                console.log("post", response);
                // navigator("/food/");
            })
            .catch((error) => {
                console.error(error);
            });
    };

    return (
        <>
            <div>
                <h1>{food && food[1]}</h1>
                <h2>不足数</h2>
                <form onSubmit={handlePost}>
                    <div>
                        {food && food[0] ? (
                            food[0].map((f: any) => (
                                <div key={f.id}>
                                    <p>{f.name}</p>
                                    <p>{f.food_amount}個</p>
                                </div>
                            ))
                        ) : (
                            <p>不足分はありません</p>
                        )}

                        {food && food[0] && (
                            <Button type="submit">購入リストに追加する</Button>
                        )}
                    </div>
                </form>
            </div>
            <div>
                <h2>使用食材</h2>
                <div>
                    {food &&
                        food[2].map((f: any) => (
                            <>
                                <div key={f.food_id}>
                                    <p>{f.name}</p>
                                    <p>使用数{f.food_amount}個</p>
                                </div>
                            </>
                        ))}
                </div>
            </div>
        </>
    );
};
export default MenuCook;