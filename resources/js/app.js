import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse'
import courseApp from './components/CourseApp';
import { select} from './components/SelectApp';

window.Alpine = Alpine;

window.select = select;

Alpine.plugin(focus);
Alpine.plugin(collapse)

Alpine.start();
