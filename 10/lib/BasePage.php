<?php

abstract class BasePage {

    abstract public function buildContent();

    public function display() {
        $html = implode(
            '',
            [
                $this -> buildHeader(),
                $this -> buildContent(),
                $this -> buildFooter()
            ]
        );
        echo $html;
    }

    private function buildHeader() {
        return Template::build(
            file_get_contents('./templates/header.tpl'),
            []
        );
    }

    private function buildFooter() {
        return Template::build(
            file_get_contents('./templates/footer.tpl'),
            []
        );
    }
}
