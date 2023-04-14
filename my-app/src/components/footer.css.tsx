import styled from "styled-components";
import { Box, Text } from "@chakra-ui/react";
import { FooterTagu } from "../tags/Footer";
import { FooterElement } from "../tags/FooterElement";

export const Footer = () => {
    return (
        <FooterTagu>
            <FooterElement href="/Food/">
                <SPtagu>食材</SPtagu>
            </FooterElement>
            <FooterElement href="/menu/">
                <SPtagu>メニュー</SPtagu>
            </FooterElement>
            <FooterElement href="/buyList/">
                <SPtagu>
                    <Text>買い物</Text>
                    <Text>リスト</Text>
                </SPtagu>
            </FooterElement>
            <FooterElement href="/cookingList/">
                <SPtagu>調理リスト</SPtagu>
            </FooterElement>
        </FooterTagu>
    );
};

const SPtagu = styled.p`
    color: black;
`;
