import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const dir = path.dirname(fileURLToPath(import.meta.url));

const CORE = {
    the: ['դետերմինանտ, այդ', 'этот, тот', 'det'],
    of: ['-ի, -ից', 'из, от', 'prep'],
    and: ['և, ու', 'и', 'conj'],
    to: ['դեպի, -ել', 'к, в', 'prep'],
    in: ['-ում, մեջ', 'в', 'prep'],
    a: ['մի, անորոշ հոդ', 'неопределённый артикль', 'det'],
    is: ['է', 'есть', 'verb'],
    that: ['որ, այն', 'что, тот', 'pron'],
    for: ['համար', 'для', 'prep'],
    as: ['որպես, ինչպես', 'как', 'conj'],
    it: ['այն, դա', 'это, оно', 'pron'],
    was: ['էր', 'был', 'verb'],
    with: ['հետ, -ով', 'с', 'prep'],
    on: ['վրա, -ին', 'на', 'prep'],
    be: ['լինել', 'быть', 'verb'],
    not: ['ոչ, չ-', 'не', 'adv'],
    by: ['կողմից, մոտ', 'у, к, посредством', 'prep'],
    i: ['ես', 'я', 'pron'],
    this: ['սա, այս', 'этот', 'det'],
    are: ['են', 'являются', 'verb'],
    he: ['նա (տղամարդ)', 'он', 'pron'],
    or: ['կամ', 'или', 'conj'],
    from: ['-ից', 'из, от', 'prep'],
    at: ['-ում, մոտ', 'у, в, на', 'prep'],
    his: ['նրա', 'его', 'det'],
    an: ['մի', 'неопределённый артикль', 'det'],
    have: ['ունենալ', 'иметь', 'verb'],
    which: ['որը', 'который', 'pron'],
    but: ['բայց', 'но', 'conj'],
    you: ['դու, դուք', 'ты, вы', 'pron'],
    they: ['նրանք', 'они', 'pron'],
    she: ['նա (կին)', 'она', 'pron'],
    we: ['մենք', 'мы', 'pron'],
    one: ['մեկ', 'один', 'num'],
    all: ['բոլոր, ամբողջ', 'все, весь', 'det'],
    can: ['կարողանալ', 'мочь', 'verb'],
    her: ['նրա, նրան', 'её, ей', 'pron'],
    has: ['ունի', 'имеет', 'verb'],
    there: ['այնտեղ, կա', 'там, есть', 'adv'],
    if: ['եթե', 'если', 'conj'],
    more: ['ավելի', 'больше', 'adv'],
    when: ['երբ', 'когда', 'adv'],
    who: ['ով', 'кто', 'pron'],
    what: ['ինչ', 'что', 'pron'],
    about: ['մասին', 'о', 'prep'],
    up: ['վերև', 'вверх', 'adv'],
    said: ['ասաց', 'сказал', 'verb'],
    out: ['դուրս', 'из, вне', 'adv'],
    them: ['նրանց', 'их', 'pron'],
    so: ['այսպես, այնպես որ', 'так, поэтому', 'adv'],
    some: ['որոշ, մի քանի', 'некоторые', 'det'],
    would: ['կ-', 'бы', 'verb'],
    my: ['իմ', 'мой', 'det'],
    no: ['ոչ, ոչ մի', 'нет, никакой', 'det'],
    into: ['մեջ, ներս', 'в', 'prep'],
    than: ['քան', 'чем', 'conj'],
    other: ['այլ', 'другой', 'adj'],
    time: ['ժամանակ, անգամ', 'время, раз', 'noun'],
    me: ['ինձ', 'мне, меня', 'pron'],
    only: ['միայն', 'только', 'adv'],
    could: ['կարող էր', 'мог', 'verb'],
    new: ['նոր', 'новый', 'adj'],
    these: ['այս', 'эти', 'det'],
    two: ['երկու', 'два', 'num'],
    may: ['կարող է', 'может', 'verb'],
    then: ['ապա, հետո', 'затем', 'adv'],
    do: ['անել', 'делать', 'verb'],
    first: ['առաջին', 'первый', 'adj'],
    any: ['ցանկացած', 'любой', 'det'],
    now: ['հիմա', 'сейчас', 'adv'],
    like: ['նման, հավանել', 'как, нравиться', 'prep'],
    people: ['մարդիկ', 'люди', 'noun'],
    year: ['տարի', 'год', 'noun'],
    your: ['քո, ձեր', 'твой, ваш', 'det'],
    good: ['լավ', 'хороший', 'adj'],
    some: ['որոշ', 'некоторые', 'det'],
    man: ['տղամարդ, մարդ', 'мужчина, человек', 'noun'],
    our: ['մեր', 'наш', 'det'],
    over: ['վրայով, ավելի', 'над, свыше', 'prep'],
    also: ['նաև', 'также', 'adv'],
    after: ['հետո, հետո', 'после', 'prep'],
    most: ['ամենաշատ', 'самый, большинство', 'adj'],
    through: ['միջով', 'через', 'prep'],
    back: ['հետ, մեջք', 'назад, спина', 'adv'],
    much: ['շատ', 'много', 'adv'],
    where: ['որտեղ', 'где', 'adv'],
    how: ['ինչպես', 'как', 'adv'],
    well: ['լավ', 'хорошо', 'adv'],
    work: ['աշխատանք, աշխատել', 'работа, работать', 'noun'],
    should: ['պետք է', 'следует', 'verb'],
    because: ['քանի որ', 'потому что', 'conj'],
    very: ['շատ', 'очень', 'adv'],
    just: ['հենց, պարզապես', 'просто, только что', 'adv'],
    even: ['նույնիսկ', 'даже', 'adv'],
    those: ['այն', 'те', 'det'],
    before: ['առաջ, նախքան', 'до, перед', 'prep'],
    here: ['այստեղ', 'здесь', 'adv'],
    too: ['նույնպես, չափազանց', 'тоже, слишком', 'adv'],
    make: ['պատրաստել, անել', 'делать', 'verb'],
    many: ['շատ', 'много', 'det'],
    such: ['այդպիսի', 'такой', 'det'],
    being: ['լինելը, էակ', 'бытие', 'noun'],
    long: ['երկար', 'длинный, долгий', 'adj'],
    day: ['օր', 'день', 'noun'],
    life: ['կյանք', 'жизнь', 'noun'],
    did: ['արեց', 'делал', 'verb'],
    get: ['ստանալ', 'получать', 'verb'],
    own: ['սեփական', 'собственный', 'adj'],
    say: ['ասել', 'сказать', 'verb'],
    way: ['ճանապարհ, ձև', 'путь, способ', 'noun'],
    between: ['միջև', 'между', 'prep'],
    go: ['գնալ', 'идти', 'verb'],
    come: ['գալ', 'приходить', 'verb'],
    made: ['պատրաստված, արեց', 'сделал', 'verb'],
    still: ['դեռ', 'всё ещё', 'adv'],
    see: ['տեսնել', 'видеть', 'verb'],
    know: ['իմանալ', 'знать', 'verb'],
    take: ['վերցնել', 'брать', 'verb'],
    year: ['տարի', 'год', 'noun'],
    world: ['աշխարհ', 'мир', 'noun'],
    school: ['դպրոց', 'школа', 'noun'],
    house: ['տուն', 'дом', 'noun'],
    water: ['ջուր', 'вода', 'noun'],
    food: ['սնունդ', 'еда', 'noun'],
    love: ['սեր, սիրել', 'любовь, любить', 'noun'],
    family: ['ընտանիք', 'семья', 'noun'],
    friend: ['ընկեր', 'друг', 'noun'],
    child: ['երեխա', 'ребёнок', 'noun'],
    woman: ['կին', 'женщина', 'noun'],
    city: ['քաղաք', 'город', 'noun'],
    country: ['երկիր', 'страна', 'noun'],
    language: ['լեզու', 'язык', 'noun'],
    english: ['անգլերեն', 'английский', 'adj'],
    armenian: ['հայերեն, հայ', 'армянский', 'adj'],
    russian: ['ռուսերեն, ռուս', 'русский', 'adj'],
};

function levelFor(rank) {
    if (rank <= 800) return 'A1';
    if (rank <= 2000) return 'A2';
    if (rank <= 4000) return 'B1';
    if (rank <= 8000) return 'B2';
    if (rank <= 14000) return 'C1';
    return 'C2';
}

function cleanSpaces(text) {
    let value = String(text || '').replace(/\s+/g, ' ').trim();
    for (let i = 0; i < 6; i += 1) {
        value = value.replace(/([\u0530-\u058F])\s+([\u0530-\u058F])/g, '$1$2');
    }
    return value;
}

function firstGloss(text, script) {
    const cleaned = cleanSpaces(text)
        .replace(/\[[^\]]*\]/g, ' ')
        .replace(/[A-Za-z~`.']/g, ' ')
        .replace(/\s+/g, ' ')
        .trim();

    const parts = cleaned
        .split(/[․։;]/)
        .map((part) => part.trim())
        .filter(Boolean);

    const picked = [];
    for (const part of parts) {
        const bits = part.split(',').map((bit) => bit.trim()).filter((bit) => {
            if (script === 'hy') return /[\u0530-\u058F]/.test(bit);
            return /[А-Яа-яЁё]/.test(bit);
        });
        picked.push(...bits);
        if (picked.length >= 3) break;
    }

    return picked.slice(0, 3).join(', ').slice(0, 180);
}

function extractHy(definition) {
    const withoutIpa = definition.replace(/^\[[^\]]*\]\s*/, '');
    const posMatch = withoutIpa.match(/^(n|v|a|adj|adv|prep|conj|pron|num|interj|vt|vi|pl|p\.p\.)\s+/i);
    const rest = posMatch ? withoutIpa.slice(posMatch[0].length) : withoutIpa;
    const untilBreak = rest.split(/[․։]/)[0] || rest;
    return firstGloss(untilBreak, 'hy');
}

function extractPos(definition) {
    const match = definition.match(/^\[[^\]]*\]\s*([a-z.]+)/i);
    if (!match) return null;
    const raw = match[1].toLowerCase();
    const map = {
        n: 'noun', v: 'verb', vt: 'verb', vi: 'verb', a: 'adjective', adj: 'adjective',
        adv: 'adverb', prep: 'preposition', conj: 'conjunction', pron: 'pronoun',
        num: 'number', interj: 'interjection', pl: 'noun',
    };
    return map[raw] || raw.slice(0, 24);
}

function guessPos(word) {
    if (word.endsWith('ly') && word.length > 4) return 'adverb';
    if (word.endsWith('tion') || word.endsWith('ness') || word.endsWith('ment')) return 'noun';
    if (word.endsWith('ous') || word.endsWith('ful') || word.endsWith('less') || word.endsWith('able')) return 'adjective';
    if (word.endsWith('ing') || word.endsWith('ed')) return 'verb';
    return 'noun';
}

const IRREGULAR = {
    is: 'be', was: 'be', are: 'be', were: 'be', been: 'be', am: 'be', being: 'be',
    has: 'have', had: 'have', having: 'have',
    did: 'do', does: 'do', doing: 'do', done: 'do',
    said: 'say', says: 'say', saying: 'say',
    made: 'make', making: 'make',
    went: 'go', gone: 'go', going: 'go',
    came: 'come', coming: 'come',
    took: 'take', taken: 'take', taking: 'take',
    got: 'get', getting: 'get', gotten: 'get',
    knew: 'know', known: 'know', knowing: 'know',
    thought: 'think', thinking: 'think',
    saw: 'see', seen: 'see', seeing: 'see',
    gave: 'give', given: 'give', giving: 'give',
    found: 'find', finding: 'find',
    left: 'leave', leaving: 'leave',
    felt: 'feel', feeling: 'feel',
    became: 'become', becoming: 'become',
    began: 'begin', begun: 'begin', beginning: 'begin',
    ran: 'run', running: 'run',
    wrote: 'write', written: 'write', writing: 'write',
    told: 'tell', telling: 'tell',
    heard: 'hear', hearing: 'hear',
    brought: 'bring', bringing: 'bring',
    sat: 'sit', sitting: 'sit',
    stood: 'stand', standing: 'stand',
    men: 'man', women: 'woman', children: 'child', people: 'person',
    years: 'year', days: 'day', times: 'time', things: 'thing',
    states: 'state', others: 'other', himself: 'self', themselves: 'self',
    using: 'use', based: 'base', called: 'call',
    better: 'good', best: 'good', worse: 'bad', worst: 'bad',
    more: 'much', most: 'much', less: 'little', least: 'little',
};

function stems(word) {
    const out = [word];
    if (IRREGULAR[word]) out.push(IRREGULAR[word]);
    const rules = [
        [/ies$/, 'y'], [/ses$/, 's'], [/xes$/, 'x'], [/zes$/, 'z'],
        [/ches$/, 'ch'], [/shes$/, 'sh'],
        [/nning$/, 'n'], [/tting$/, 't'], [/mming$/, 'm'],
        [/ing$/, ''], [/ing$/, 'e'],
        [/ied$/, 'y'], [/ed$/, ''], [/ed$/, 'e'],
        [/ly$/, ''], [/ness$/, ''], [/ment$/, ''],
        [/ers$/, 'er'], [/est$/, ''],
        [/s$/, ''],
    ];
    for (const [re, rep] of rules) {
        if (re.test(word) && word.length > 4) {
            out.push(word.replace(re, rep));
        }
    }
    return [...new Set(out.filter((item) => item.length > 1))];
}

function loadBaratian(file) {
    const hy = new Map();
    const pos = new Map();
    const text = fs.readFileSync(file, 'utf8');
    for (const line of text.split(/\r?\n/)) {
        if (!line.includes('\t')) continue;
        const tab = line.indexOf('\t');
        const key = line.slice(0, tab).trim().toLowerCase();
        const def = line.slice(tab + 1);
        let word = key.split(/[,/;]/)[0].trim();
        word = word.replace(/\s+(i{1,3}|iv|vi{0,3}|ix|x)$/i, '');
        word = word.replace(/\s+\d+$/, '');
        word = word.replace(/\s+/g, '').replace(/[^a-z'-]/g, '');
        if (!word || word.length > 32) continue;
        if (!hy.has(word)) {
            const translation = extractHy(def);
            if (translation) hy.set(word, translation);
            const part = extractPos(def);
            if (part) pos.set(word, part);
        }
    }
    return { hy, pos };
}

function loadOpenRussian(files) {
    const ru = new Map();
    for (const file of files) {
        const text = fs.readFileSync(file, 'utf8');
        const lines = text.split(/\r?\n/);
        const header = lines.shift().split('\t');
        const enIdx = header.indexOf('translations_en');
        const ruIdx = header.indexOf('bare');
        if (enIdx < 0 || ruIdx < 0) continue;
        for (const line of lines) {
            if (!line) continue;
            const cols = line.split('\t');
            const russian = (cols[ruIdx] || '').trim();
            const english = (cols[enIdx] || '').trim().toLowerCase();
            if (!russian || !english) continue;
            const tokens = english.split(/[;,]/).map((token) => token.replace(/[^a-z'-]/g, '').trim()).filter(Boolean);
            for (const token of tokens) {
                if (!ru.has(token)) ru.set(token, russian.slice(0, 180));
            }
        }
    }
    return ru;
}

function lookup(map, word) {
    if (map.has(word)) return map.get(word);
    for (const stem of stems(word)) {
        if (map.has(stem)) return map.get(stem);
    }
    if (word.includes('-')) {
        return lookup(map, word.split('-')[0]);
    }
    return '';
}

const englishRaw = fs.readFileSync(path.join(dir, 'english-20000.txt'));
const englishText = englishRaw.includes(0)
    ? englishRaw.toString('utf16le').replace(/^\uFEFF/, '')
    : englishRaw.toString('utf8').replace(/^\uFEFF/, '');
const english = englishText
    .split(/\r?\n/)
    .map((word) => word.replace(/\0/g, '').trim().toLowerCase().normalize('NFKD').replace(/[\u0300-\u036f]/g, ''))
    .filter((word) => /^[a-z][a-z'.-]*$/.test(word));

const unique = [];
const seen = new Set();
for (const word of english) {
    if (seen.has(word)) continue;
    seen.add(word);
    unique.push(word);
    if (unique.length === 20000) break;
}

const { hy, pos } = loadBaratian(path.join(dir, 'baratian.tab'));
const ru = loadOpenRussian([
    path.join(dir, 'openrussian-others.csv'),
    path.join(dir, 'openrussian-nouns.csv'),
    path.join(dir, 'openrussian-verbs.csv'),
    path.join(dir, 'openrussian-adjectives.csv'),
]);

const rows = [['word', 'translation_hy', 'translation_ru', 'level', 'part_of_speech', 'frequency_rank']];
let missingHy = 0;
let missingRu = 0;

if (unique.length < 20000) {
    for (const extra of hy.keys()) {
        if (seen.has(extra) || extra.length < 3) continue;
        seen.add(extra);
        unique.push(extra);
        if (unique.length === 20000) break;
    }
}

unique.forEach((word, index) => {
    const rank = index + 1;
    const core = CORE[word];
    const translationHy = core?.[0] || lookup(hy, word);
    const translationRu = core?.[1] || lookup(ru, word);
    const part = core?.[2] || pos.get(word) || guessPos(word);
    if (!translationHy) missingHy += 1;
    if (!translationRu) missingRu += 1;
    rows.push([
        word,
        translationHy || word,
        translationRu || word,
        levelFor(rank),
        part,
        String(rank),
    ]);
});

const csv = rows.map((cols) => cols.map((col) => `"${String(col).replaceAll('"', '""')}"`).join(',')).join('\n');
fs.writeFileSync(path.join(dir, 'words.csv'), csv, 'utf8');

console.log(`Wrote ${unique.length} words`);
console.log(`Missing HY: ${missingHy}, missing RU: ${missingRu}`);
