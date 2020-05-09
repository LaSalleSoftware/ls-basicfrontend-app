Laravel Mix and [TailWind CSS Framework](https://tailwindcss.com/) are already set-up. 

So, the only thing that you have to do to get going is to this CLI command from the project root:

``` npm install ```

I use some stuff from TailWind

Then, it's the same `npm run dev` and `npm run production` as usual. 

If you want to update, this command will update non-major version updates (per SemVer):

``` npm update ```

To update major version updates (eg: from version 1.2.2 to version 2.0.0), run:

``` npm outdated ```

Then manually update package.json, and install these new major versions:

``` npm install ```

Update:
- run `npm install @tailwindcss/ui`

Notes:
- I am using less.
- Helpful article: [gyp: No Xcode or CLT version detected macOS Catalina](https://medium.com/flawless-app-stories/gyp-no-xcode-or-clt-version-detected-macos-catalina-anansewaa-38b536389e8d)
- I have pre-installed `tailwindcss/ui`

