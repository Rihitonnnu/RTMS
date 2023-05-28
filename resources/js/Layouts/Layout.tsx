import Header from './Header';

type LayoutProps = { children: any };

function Layout({ children }: LayoutProps) {
  return (
    <div>
      <main>
        <Header />
        {children}
      </main>
    </div>
  );
}

export default Layout;
