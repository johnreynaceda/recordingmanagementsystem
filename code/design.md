# TMCNHS Public Website Design Principles

This document captures the design system and interface principles used by `resources/views/welcome-modern.blade.php`. Use it as the reference when creating or updating public-facing TMCNHS pages.

## 1. Design Intent

The interface should feel like a credible, welcoming, and modern official school website. It should emphasize school identity, public information, enrollment, announcements, and secure portal access.

The visual direction is:

- Professional without feeling corporate or impersonal
- Modern without looking like a generic software dashboard
- Spacious, calm, and easy to scan
- Clearly associated with TMCNHS through controlled crimson accents
- Light-themed, with excellent readability and contrast
- Functional and trustworthy before decorative

## 2. Core Principles

### Information first

Every section should have a clear purpose. Important actions and information must be visible without competing decorative elements.

### Controlled school branding

Crimson identifies important labels, actions, icons, and active states. Large red surfaces are reserved for primary actions and focused calls to action. Most of the page remains white or warm off-white.

### Strong visual hierarchy

Use size, weight, spacing, and color to establish this order:

1. Page or section headline
2. Supporting description
3. Primary action
4. Secondary action or metadata

### Consistency builds trust

Cards, buttons, icons, headings, and section spacing should use the same patterns throughout the public website.

### Progressive disclosure

Show concise summaries on the landing page, then link to dedicated pages for full histories, enrollment details, and announcements.

## 3. Color System

### Primary colors

| Role | Color | Typical use |
| --- | --- | --- |
| School crimson | `#A71930` | Primary buttons, important headings, links, active states |
| Accent crimson | `#B4233B` | Focus rings, dots, borders, gradient highlights |
| Dark crimson | `#861326` | Primary-button hover state |
| Deep crimson | `#8F142A` | CTA gradients and stronger branded surfaces |
| Deep navy | `#101928` | Main headings and high-emphasis text |

### Neutral colors

| Role | Color or Tailwind token | Typical use |
| --- | --- | --- |
| White | `#FFFFFF` | Cards, navigation, major content surfaces |
| Warm off-white | `#FBFAF8` | Alternating sections and page background |
| Soft off-white | `#FDFCFB` | Statistic and secondary cards |
| Slate 800 | `text-slate-800` | Strong body or control text |
| Slate 600 | `text-slate-600` | Main descriptive text |
| Slate 500 | `text-slate-500` | Supporting descriptions |
| Slate 400 | `text-slate-400` | Dates and low-emphasis metadata |
| Slate 200 | `border-slate-200` | Default neutral borders |

### Color usage rules

- Keep the dominant page surfaces white and warm off-white.
- Use deep navy instead of pure black for headings.
- Use crimson selectively to communicate identity and priority.
- Use `red-50`, `red-100`, and `red-200` for subtle icon surfaces, rings, and borders.
- Never place long passages on saturated red backgrounds.
- Ensure text remains readable over photographs by using a strong white overlay.

## 4. Typography

The public layout uses **Manrope** with sans-serif fallback.

### Type hierarchy

- Hero heading: extra bold, approximately `40px` on mobile to `62px` on large screens
- Section heading: extra bold, `30px–36px`
- Card heading: extra bold, `16px–20px`
- Body copy: medium or regular, `14px–18px`, with generous line height
- Eyebrow label: `10px–12px`, extra bold, uppercase, with wide letter spacing
- Metadata: `10px–12px`, bold or semibold, in a muted slate color

### Typography rules

- Use `font-extrabold` for major headings and important actions.
- Use tight negative tracking for large headings: approximately `-0.035em`.
- Use generous line heights for descriptive content: `leading-7` or `leading-8`.
- Keep paragraphs within a readable width, usually `max-w-xl` or `max-w-2xl`.
- Avoid oversized headings that overwhelm the school content.
- Use sentence case for headings and actions; reserve uppercase for short eyebrow labels.

## 5. Layout and Spacing

### Page container

Use a centered maximum width of `max-w-7xl` with responsive horizontal padding:

```html
class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8"
```

### Section rhythm

- Standard major section: `py-20 sm:py-24`
- Compact section: `py-10` to `py-16`
- Major content gap: `gap-10` to `gap-16`
- Card grid gap: `gap-3` to `gap-5`
- Card padding: `p-5` to `p-7`

Alternate white and warm off-white section backgrounds to separate content without heavy dividers.

### Grid behavior

- Build mobile layouts as a single column first.
- Use two columns only when the content relationship benefits from it.
- The hero uses a 12-column desktop grid: seven columns for the message and five for portal access.
- Three-card content grids become three columns at `md`.
- Four-card statistic grids use two columns at `sm` and four at `lg`.

## 6. Hero Pattern

The homepage hero combines an authentic campus image with a highly legible content layer.

### Structure

- Full-width campus photograph
- White left-to-right overlay for readable text
- Soft bottom overlay that blends into the next section
- Left column for identity, message, and actions
- Right column for the portal access card

### Content order

1. Small official-portal badge
2. School name as the main heading
3. Short welcoming description
4. Primary and secondary calls to action
5. Small supporting trust or history statement

### Image rules

- Prefer authentic school photography over generic stock images.
- Keep the image visible but subordinate to the information.
- Use `object-cover` and a deliberate focal position.
- Never depend on the image itself for text contrast.

## 7. Card System

### Standard content card

```text
Background: white
Border: 1px slate-200
Radius: 20px
Padding: 24px–28px
Shadow: subtle at rest
Hover: slight upward movement, red-tinted border, soft elevated shadow
```

Recommended interaction:

```html
class="rounded-[20px] border border-slate-200 bg-white p-7 shadow-sm
       transition duration-300 hover:-translate-y-1 hover:border-red-200
       hover:shadow-xl hover:shadow-slate-200/70"
```

### Premium portal card

- Maximum width of approximately `470px`
- `24px` corner radius
- Thin neutral border
- Stronger but natural shadow
- Narrow crimson gradient accent across the top
- Clear heading and security message
- Two large, full-width portal choices

### Statistic card

- Compact horizontal layout
- Small tinted icon container
- Large numeric value
- Short label beneath the value
- Minimal hover treatment

### Announcement card

- Equal-height vertical card where possible
- Date and category at the top
- Concise headline and summary
- Action anchored near the bottom using `mt-auto`
- Description limited to a few lines on summary pages

## 8. Buttons and Links

### Primary button

- Crimson background
- White text
- Minimum height of `48px`
- `12px` radius
- Strong label weight
- Darker crimson on hover
- Slight upward movement on hover
- Visible crimson focus ring

### Secondary button

- White background
- Neutral border
- Deep slate text
- Red-tinted border and text on hover

### Text action

- Crimson, extra-bold text
- Directional arrow where useful
- Arrow may move slightly on hover

### Interaction rules

- Use transitions of approximately `300ms`.
- Keep movement subtle: `-translate-y-0.5` or `-translate-y-1`.
- Use `active:translate-y-0` to provide a clear pressed state.
- Every interactive element must have a visible keyboard focus state.
- Never rely on color alone to communicate clickability.

## 9. Iconography

- Use consistent inline outline SVG icons.
- Preferred stroke width is approximately `1.7–2`.
- Use rounded line caps and joins.
- Place important icons inside `44px–48px` softly tinted containers.
- Use crimson icons on `red-50` with a subtle `red-100` ring.
- Mark decorative icons with `aria-hidden="true"`.
- Icons should support labels, not replace them for important actions.

## 10. Section Patterns

### Section introduction

Most major sections should use:

1. Crimson uppercase eyebrow
2. Deep navy heading
3. Short slate supporting description

Centered introductions suit balanced card groups. Left-aligned introductions suit news, program, and task-oriented content.

### School at a Glance

- Compact and data-focused
- Real portal values where available
- Values displayed prominently
- Clear note when figures come from live records
- Avoid invented numbers

### Mission, Vision, and Values

- Three balanced cards
- One simple icon per principle
- Short, readable descriptions
- Equal visual emphasis across all three cards

### Programs

- Keep summaries concise
- Use simple numeric ordering where helpful
- Explain the learner benefit rather than only naming the curriculum

### Enrollment CTA

- One of the few justified large crimson surfaces
- Soft, restrained two-color crimson gradient
- Concise message with a single white action button
- Rounded `24px` container with ample padding

## 11. Responsive Design

The design is mobile-first.

- Start with single-column content.
- Stack CTA buttons on small screens and place them inline from `sm` upward.
- Collapse the hero into one column before `lg`.
- Keep portal options large enough for touch interaction.
- Use responsive padding rather than fixed outer margins.
- Avoid horizontal scrolling in content cards.
- Preserve useful spacing instead of compressing every section on mobile.
- Keep navigation labels in a dedicated mobile menu rather than shrinking desktop navigation.

## 12. Accessibility

- Use semantic landmarks: `header`, `nav`, `main`, `section`, `article`, and `footer`.
- Associate sections with headings using `aria-labelledby`.
- Provide meaningful image alternative text; use empty `alt` text for purely decorative images.
- Use a skip-to-content link at the beginning of the page.
- Maintain strong text contrast on all backgrounds.
- Provide `focus-visible` rings for links, buttons, and navigation controls.
- Expose mobile-menu state using `aria-expanded` and `aria-controls`.
- Use `time` elements with machine-readable `datetime` values.
- Keep body text at a readable size and line height.
- Use minimum interactive heights near `44px–48px`.

## 13. Motion and Effects

Motion should clarify interaction, not decorate the page continuously.

- Use short transitions around `200–300ms`.
- Limit hover translation to a few pixels.
- Use soft shadow changes to reinforce elevation.
- Move directional arrows slightly to indicate navigation.
- Avoid looping animations, excessive blur, bouncing, or animated gradients.
- Avoid glassmorphism except for a very subtle backdrop treatment where text contrast remains strong.

## 14. Content Principles

- Write in a welcoming but official tone.
- Keep landing-page descriptions concise.
- Prefer plain language over institutional jargon.
- Use real school information and live data whenever possible.
- Never fabricate enrollment figures, dates, programs, or announcements.
- Make calls to action explicit: “Explore Our School,” “View Announcements,” or “View Enrollment Process.”
- Present portal access as one part of the official school website, not the entire purpose of the site.

## 15. Avoid

- Dark mode or a dark-dominant public interface
- Large uninterrupted red backgrounds
- Excessive gradients
- Excessive glassmorphism or blur
- Oversized headings and cards
- Heavy shadows on every element
- Long text inside small cards
- Generic stock-school imagery when authentic photographs are available
- Multiple equally prominent primary actions
- Placeholder links or misleading public information
- Decorative animation that distracts from school content

## 16. Implementation Checklist

Before completing a public page, verify that:

- The page uses the shared `x-landing-layout` wrapper.
- The correct navigation item has an active state.
- Main content fits within `max-w-7xl`.
- The page uses white and `#FBFAF8` as dominant surfaces.
- Headings use deep navy and accents use controlled crimson.
- Cards use consistent radii, borders, padding, and hover behavior.
- Descriptions have readable line lengths and line heights.
- Buttons include hover, active, and keyboard-focus states.
- Images have correct alternative text.
- Mobile content stacks cleanly with no horizontal overflow.
- Dynamic data has a safe and informative empty state.
- Blade templates compile and the production CSS build succeeds.

