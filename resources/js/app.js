import './bootstrap';
import 'flowbite';
import SimpleBar from "simplebar";



Array.prototype.forEach.call(
    document.querySelectorAll('#scroll'),
    (el) => new SimpleBar(el)
);

