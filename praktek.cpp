#include <iostream>;

using namespace std;

int main()
{

    int w1 = 1;
    int w2 = 1;
    int tetha = 2;

    int x1[4] = {0, 0, 1, 1};
    int x2[4] = {0, 1, 0, 1};
    int y[4] = {0, 0, 0, 1};

    int net[4] = {x1[0] * w1 + x2[0] * w2, x1[1] * w1 + x2[1] * w2, x1[2] * w1 + x2[2] * w2, x1[3] * w1 + x2[3] * w2};

    int hasil[4];

    for (int i = 0; i < 4; i++)
    {
        if (net[i] < tetha)
        {
            hasil[i] = 0;
        }
        else
        {
            hasil[i] = 1;
        }
    }

    string kesimpulan;
    if (/* condition */)
    {
        /* code */
    }

    return 0;
}