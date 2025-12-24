import { createI18n } from 'vue-i18n';
import ar from "./translation/ar.json";
import en from "./translation/en.json";

let lang = $('meta[name="language"]').attr('content')
const i18n = createI18n({
    locale: lang, // set locale
    fallbackLocale: lang, // set fallback locale
    legacy:false,
    messages: {
        ar,en
    }
});


export default i18n;
