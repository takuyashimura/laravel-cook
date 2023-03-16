import styled from "styled-components";

export const Footer = () => {
    return (
        <SContainer>
            <SMenu href="/Food/">
                <SPtagu>食材</SPtagu>
            </SMenu>
            <SMenu href="/menu/">
                <SPtagu>メニュー</SPtagu>
            </SMenu>
            <SMenu href="#">
                <SPtagu>買い物リスト（リンク先未設定）</SPtagu>
            </SMenu>
            <SMenu href="#">
                <SPtagu>調理リスト（リンク先未設定）</SPtagu>
            </SMenu>
        </SContainer>
    );
};
const SContainer = styled.div`
    background-color: #eeeeee;
    position: fixed;
    bottom: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
`;

const SMenu = styled.a`
    display: flex;
    width: 25%;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    border: 1px solid #333;
`;
const SPtagu = styled.p`
    color: black;
`;
