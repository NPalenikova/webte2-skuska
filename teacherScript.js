


const directory = 'latex_subory';
const fileExtension = '.tex';

fetch(directory)
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const files = Array.from(doc.querySelectorAll('a[href]'))
            .map(a => a.href.split('/').pop())
            .filter(name => name.endsWith(fileExtension));
        files.forEach(file => {
            fetch(`${directory}/${file}`)
                .then(response => response.text())
                .then(content => console.log(content));
        });
    });
const sectionRegex = /\\section\*{(.+?)}([\s\S]*?)(?=\\section|$)/gs;
const descriptionRegex = /\\begin{task}([\s\S]*?)\\end{task}|\\includegraphics/;
const equationRegex = /\\begin{equation\*}([\s\S]*?)\\end{equation\*}/;
const imageRegex = /\\includegraphics{(?:zadanie99\/)?([^{}]+)}/;

fetch('latex_subory/odozva01pr.tex')
    .then(response => response.text())
    .then(text => {
        const sections = [];x;
        let sectionMatch;
        while ((sectionMatch = sectionRegex.exec(text)) !== null) {
            const sectionTitle = sectionMatch[1];
            let sectionContent = sectionMatch[2];
            console.log(sectionContent)
            let equation = "";
            const equationMatch = equationRegex.exec(sectionContent);
            if (equationMatch !== null) {
                equation = equationMatch[1].trim();
            }
            let imageSrc = "";
            const imageMatch = imageRegex.exec(sectionContent);
            if (imageMatch !== null) {
                imageSrc = imageMatch[1].trim();
            }
            let description = "";
            const descriptionMatch = descriptionRegex.exec(sectionContent);
            if (descriptionMatch !== null) {
                description = descriptionMatch[1].trim();
            }
            sections.push({
                title: sectionTitle,
                equation: equation,
                imageSrc: imageSrc,
                description: description
            });
        }
        console.log(sections);
    });
