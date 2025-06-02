CREATE TABLE header (
    id INT AUTO_INCREMENT PRIMARY KEY,
    logo_url VARCHAR(255),
    linkedin_url VARCHAR(255),
    github_url VARCHAR(255),
    navigation_links JSON
);

ALTER TABLE header ADD social_links JSON;

UPDATE header SET social_links = '[
    {"platform": "LinkedIn", "url": "https://linkedin.com", "icon": "path/to/linkedin-icon.png"},
    {"platform": "GitHub", "url": "https://github.com", "icon": "path/to/github-icon.png"}
]' WHERE id = 1;
