module.exports = {
  content: [
    '404.php',
    './header.php',
    './footer.php',
    './inc/**/*.php',
    './templates/**/*.php',
    './src/vue/*.vue',
    './src/svgs/*.svg',
  ],
  theme: {
    container: {
      center: true,
    },
    fontFamily: {
      poppins: ['Poppins', 'sans-serif'],
      runda: ['Runda'],
    },
    extend: {
      backgroundOpacity: {
        15: '0.15',
        35: '0.35',
        85: '0.85',
      },
      backgroundPosition: {
        'right-center': '100% 50%',
      },
      backgroundSize: {
        1.2: '1.2rem',
      },
      colors: {
        beige: {
          200: '#EFE7DA',
          300: '#D9D4CB',
          500: '#C7BEB0',
          800: '#948C7E',
        },
        blue: {
          100: '#E5F1FF',
          400: '#A1C5DD',
          500: '#7BA0BB',
          700: '#426D8D',
        },
        gray: {
          100: '#E5E5E5',
          200: '#CCCCCC',
          300: '#A8A8A8',
          400: '#B2B2B2',
          500: '#707070',
          800: '#434343',
        },
        green: {
          400: '#80AE9A',
          500: '#699382',
          600: '#456E63',
          800: '#35584E',
          900: '#2A4A41',
        },
        orange: {
          500: '#FF4C00',
        },
        yellow: {
          500: '#F6B92C',
        },
      },
      fontSize: {
        1.375: '1.375rem',
        1.75: '1.75rem',
        2: '2rem',
        2.5: '2.5rem',
        2.75: '2.75rem',
        3.375: '3.375rem',
        3.75: '3.75rem',
      },
      inset: {
        '-999': '-999rem',
        18: '4.5rem',
        full: '100%',
      },
      lineHeight: {
        6.25: '1.5625rem',
      },
      maxHeight: {
        none: 'none',
      },
      opacity: {
        55: '.55',
      },
      screens: {
        '2xl': '1440px',
        narrow: { raw: '(max-height: 750px) and (min-width: 1024px)' },
      },
      spacing: {
        18: '4.5rem',
        27: '6.75rem',
      },
      strokeWidth: {
        3: '3px',
      },
      transitionDuration: {
        550: '550ms',
      },
      typography: {
        mobile: {
          css: {
            fontSize: '1rem',
            lineHeight: '1.4375rem',
            h1: {
              fontSize: '2.65rem',
              lineHeight: '2.4rem',
            },
            h2: {
              fontSize: '2.5rem',
              lineHeight: '2.2rem',
            },
            h3: {
              fontSize: '2.125rem',
              lineHeight: '1.95rem',
            },
          },
        },
        tablet: {
          css: {
            fontSize: '1.125rem',
            lineHeight: '1.625rem',
            h1: {
              fontSize: '6.75rem',
              lineHeight: '5.2rem',
            },
            h2: {
              fontSize: '4.125rem',
              lineHeight: '3.65rem',
            },
            h3: {
              fontSize: '2.25rem',
              lineHeight: '2.1rem',
            },
          },
        },
        desktop: {
          css: {
            fontSize: '1.125rem',
            lineHeight: '1.625rem',
            h1: {
              fontSize: '10rem',
              lineHeight: '7.5rem',
            },
            h2: {
              fontSize: '4.125rem',
              lineHeight: '3.65rem',
            },
            h3: {
              fontSize: '2.75rem',
              lineHeight: '2.5rem',
            },
          },
        },
      },
      zIndex: {
        '-10': '-10',
      },
      transitionProperty: {
        dimentions: 'width, height',
      },
    },
  },
  variants: {
    extend: {
      display: ['motion-reduce', 'motion-safe'],
    },
  },
  plugins: [
    require('@tailwindcss/aspect-ratio'),
    require('@tailwindcss/forms'),
    require('tailwindcss-autofill'),
    require('tailwindcss-text-fill'),
    require('tailwindcss-shadow-fill'),
    require('@tailwindcss/typography'),
  ],
};
